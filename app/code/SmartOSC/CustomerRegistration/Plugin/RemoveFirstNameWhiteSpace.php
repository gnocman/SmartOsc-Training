<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepository;

/**
 * Remove whitespace in First Name
 **/
class RemoveFirstNameWhiteSpace
{
    /**
     * @param CustomerRepository $subject
     * @param CustomerInterface $customer
     * @param $passwordHash
     * @return array
     */
    public function beforeSave(CustomerRepository $subject, CustomerInterface $customer, $passwordHash = null): array
    {
        // Only apply to the new customer
        if (!$customer->getId() && $firstName = $customer->getFirstName()) {
            $firstName = str_replace(' ', '', $firstName);
            $customer->setFirstName($firstName);
        }

        return [$customer, $passwordHash];
    }
}
