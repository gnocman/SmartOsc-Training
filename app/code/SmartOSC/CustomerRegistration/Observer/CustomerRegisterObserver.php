<?php
/**
 * Copyright © Nam Cong, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Observer;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Event\Observer;
use SmartOSC\CustomerRegistration\Model\Email;
use Magento\Framework\Event\ObserverInterface;

/**
 * Send email when customer registration account
 */
class CustomerRegisterObserver implements ObserverInterface
{
    /**
     * @var Email
     */
    private Email $helperEmail;

    /**
     * @param Email $helperEmail
     */
    public function __construct(
        Email $helperEmail
    ) {
        $this->helperEmail = $helperEmail;
    }

    /**
     * Events call to sendEmail
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var CustomerInterface $customer */
        $customer = $observer->getEvent()->getData('customer');
        $this->helperEmail->sendEmail($customer);
    }
}
