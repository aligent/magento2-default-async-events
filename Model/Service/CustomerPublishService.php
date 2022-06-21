<?php
/*
 * @author Aligent Consulting Team
 * @copyright Copyright (c) 2022 Aligent Consulting. (http://www.aligent.com.au)
 */

declare(strict_types=1);

namespace Aligent\DefaultAsyncEvents\Model\Service;

use Aligent\AsyncEvents\Helper\QueueMetadataInterface;
use Aligent\DefaultAsyncEvents\Helper\Config;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\SerializerInterface;

class CustomerPublishService
{

    /** @var PublisherInterface */
    private PublisherInterface $publisher;
    /** @var SerializerInterface */
    private SerializerInterface $serializer;
    /** @var Config */
    private Config $configHelper;

    /**
     * @param PublisherInterface $publisher
     * @param SerializerInterface $serializer
     * @param Config $configHelper
     */
    public function __construct(
        PublisherInterface $publisher,
        SerializerInterface $serializer,
        Config $configHelper
    ) {
        $this->publisher = $publisher;
        $this->serializer = $serializer;
        $this->configHelper = $configHelper;
    }

    /**
     * Publishes a shipment event if enabled
     *
     * @param CustomerInterface $customer
     * @param string $eventName
     * @return void
     */
    public function execute(CustomerInterface $customer, string $eventName): void
    {
        if ($this->configHelper->canPublishCustomer($customer)) {
            $this->publisher->publish(
                QueueMetadataInterface::EVENT_QUEUE,
                [
                    $eventName,
                    $this->serializer->serialize(['id' => $customer->getId()])
                ]
            );
        }
    }
}
