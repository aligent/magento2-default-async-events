<?php

declare(strict_types=1);

namespace Aligent\DefaultAsyncEvents\Observer;

use Aligent\DefaultAsyncEvents\Model\Service\OrderPublishService;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;

class OrderSave implements ObserverInterface
{

    /** @var OrderPublishService */
    private OrderPublishService $publishService;

    /**
     * @param OrderPublishService $publisher
     */
    public function __construct(
        OrderPublishService $publisher
    ) {
        $this->publishService = $publisher;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        /** @var OrderInterface $order */
        $order = $observer->getEvent()->getData('order');
        $this->publishService->execute($order, 'sales.order.saved');
    }
}
