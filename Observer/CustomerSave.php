<?php
/*
 * @author Aligent Consulting Team
 * @copyright Copyright (c) 2022 Aligent Consulting. (http://www.aligent.com.au)
 */

declare(strict_types=1);
namespace Aligent\DefaultAsyncEvents;

use Aligent\DefaultAsyncEvents\Model\Service\CustomerPublishService;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CustomerSave implements ObserverInterface
{

    /** @var CustomerPublishService */
    private CustomerPublishService $customerPublishService;

    /**
     * @param CustomerPublishService $customerPublishService
     */
    public function __construct(
        CustomerPublishService $customerPublishService
    ) {
        $this->customerPublishService = $customerPublishService;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        /** @var CustomerInterface $customer */
        $customer = $observer->getEvent()->getData('customer');
        $this->customerPublishService->execute($customer, 'customer.saved');
    }
}
