<?php

declare(strict_types=1);

namespace Aligent\DefaultAsyncEvents\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface AsyncCustomerManagementInterface
{
    /**
     * Get customer by Customer ID, bypassing the registry of the core repository
     *
     * @param int $customerId
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws NoSuchEntityException If customer with the specified ID does not exist.
     * @throws LocalizedException
     */
    public function getById(int $customerId): CustomerInterface;
}
