<?php
/*
 * @author Aligent Consulting Team
 * @copyright Copyright (c) 2022 Aligent Consulting. (http://www.aligent.com.au)
 */

declare(strict_types=1);
namespace Aligent\DefaultAsyncEvents\Observer;

use Aligent\DefaultAsyncEvents\Model\Service\ShipmentPublishService;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\ShipmentInterface;

class ShipmentSave implements ObserverInterface
{

    /** @var ShipmentPublishService */
    private ShipmentPublishService $shipmentPublishService;

    /**
     * @param ShipmentPublishService $shipmentPublishService
     */
    public function __construct(
        ShipmentPublishService $shipmentPublishService
    ) {
        $this->shipmentPublishService = $shipmentPublishService;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        /** @var ShipmentInterface $shipment */
        $shipment = $observer->getEvent()->getData('shipment');
        $this->shipmentPublishService->execute($shipment, 'sales.shipment.saved');
    }
}
