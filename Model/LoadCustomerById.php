<?php
/*
 * @author Aligent Consulting Team
 * @copyright Copyright (c) 2022 Aligent Consulting. (http://www.aligent.com.au)
 */

declare(strict_types=1);
namespace Aligent\DefaultAsyncEvents\Model;

use Aligent\DefaultAsyncEvents\Api\LoadCustomerByIdInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\ResourceModel\Customer as CustomerAlias;
use Magento\Framework\Exception\NoSuchEntityException;

class LoadCustomerById implements LoadCustomerByIdInterface
{

    /** @var CustomerFactory */
    private CustomerFactory $customerFactory;
    /** @var CustomerAlias */
    private CustomerAlias $customerResource;

    /**
     * @param CustomerFactory $customerFactory
     * @param CustomerAlias $customerResource
     */
    public function __construct(
        CustomerFactory $customerFactory,
        CustomerAlias $customerResource
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerResource = $customerResource;
    }

    /**
     * @inheritDoc
     *
     * @throws NoSuchEntityException
     */
    public function loadCustomerFromDb(int $customerId): CustomerInterface
    {
        /** @var Customer $customer */
        $customer = $this->customerFactory->create();
        $this->customerResource->load($customer, $customerId);
        if (!$customer->getId()) {
            // customer does not exist
            throw NoSuchEntityException::singleField('customerId', $customerId);
        }
        return $customer->getDataModel();
    }
}