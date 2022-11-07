<?php

declare(strict_types=1);

namespace Aligent\DefaultAsyncEvents\Model;

use Aligent\DefaultAsyncEvents\Api\AsyncCustomerManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\CustomerRegistry;

class AsyncCustomerManagement implements AsyncCustomerManagementInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var CustomerRegistry
     */
    private CustomerRegistry $customerRegistry;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerRegistry $customerRegistry
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerRegistry $customerRegistry
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerRegistry = $customerRegistry;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $customerId): CustomerInterface
    {
        /**
         * The CustomerRepository uses a CustomerRegistry which will cache entities on load. If the updates happen in a
         * different thread, there is a possibility that stale data is returned.
         * However, we still want to use the repository instead of using the resource model to preserve modifications
         * added by plugins.
         *
         * Therefore, manually removing the entity from the registry should guarantee that it is always loaded from the
         * database.
         */
        $this->customerRegistry->remove($customerId);
        return $this->customerRepository->getById($customerId);
    }
}
