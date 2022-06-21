<?php
/*
 * @author Aligent Consulting Team
 * @copyright Copyright (c) 2022 Aligent Consulting. (http://www.aligent.com.au)
 */

declare(strict_types=1);
namespace Aligent\DefaultAsyncEvents\Helper;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Newsletter\Model\Subscriber;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\ShipmentInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{

    private const XML_PATH_ORDER_PUBLISH_ENABLED = 'aligent_async_events/publication/order_enabled';
    private const XML_PATH_ORDER_PUBLISH_STATUSES = 'aligent_async_events/publication/order_statuses';
    private const XML_PATH_SHIPMENT_PUBLISH_ENABLED = 'aligent_async_events/publication/shipment_enabled';
    private const XML_PATH_CUSTOMER_PUBLISH_ENABLED = 'aligent_async_events/publication/customer_enabled';
    private const XML_PATH_SUBSCRIBER_PUBLISH_ENABLED = 'aligent_async_events/publication/subscriber_enabled';

    /** @var ScopeConfigInterface */
    private ScopeConfigInterface $scopeConfig;

    /** @var array */
    private array $publishedOrderStatuses;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Returns whether a given order can be published based on configuration
     *
     * @param OrderInterface $order
     * @return bool
     */
    public function canPublishOrder(OrderInterface $order): bool
    {
        $storeId = (int)$order->getStoreId();
        if ($this->scopeConfig->isSetFlag(
            self::XML_PATH_ORDER_PUBLISH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        )) {
            $publishedOrderStatuses = $this->getPublishedOrderStatuses($storeId);
            $orderStatus = $order->getStatus();
            return (in_array($orderStatus, $publishedOrderStatuses));
        }
        return false;
    }

    /**
     * Returns an array of order states that can be published
     *
     * @param int $storeId
     * @return array
     */
    private function getPublishedOrderStatuses(int $storeId) : array
    {
        if (!isset($this->publishedOrderStatuses)) {
            $publishedStatuses = (string)$this->scopeConfig->getValue(
                self::XML_PATH_ORDER_PUBLISH_STATUSES,
                ScopeInterface::SCOPE_STORE,
                $storeId
            );
            $this->publishedOrderStatuses = explode(',', $publishedStatuses);
        }
        return $this->publishedOrderStatuses;
    }

    /**
     * Returns whether a given shipment can be published based on configuration
     *
     * @param ShipmentInterface $shipment
     * @return bool
     */
    public function canPublishShipment(ShipmentInterface $shipment): bool
    {
        $storeId = (int)$shipment->getStoreId();
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SHIPMENT_PUBLISH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Returns whether a given customer can be published based on configuration
     *
     * @param CustomerInterface $customer
     * @return bool
     */
    public function canPublishCustomer(CustomerInterface $customer): bool
    {
        $storeId = (int)$customer->getStoreId();
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_CUSTOMER_PUBLISH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Returns whether a given newsletter subscriber can be published based on configuration
     *
     * @param Subscriber $subscriber
     * @return bool
     */
    public function canPublishSubscriber(Subscriber $subscriber): bool
    {
        $storeId = (int)$subscriber->getStoreId();
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SUBSCRIBER_PUBLISH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
