<?php
/*
 * @author Aligent Consulting Team
 * @copyright Copyright (c) 2022 Aligent Consulting. (http://www.aligent.com.au)
 */

declare(strict_types=1);
namespace Aligent\DefaultAsyncEvents\Api;

interface LoadCustomerByIdInterface
{
    /**
     * Load a customer from the database
     *
     * @param int $customerId
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function loadCustomerFromDb(int $customerId): \Magento\Customer\Api\Data\CustomerInterface;
}
