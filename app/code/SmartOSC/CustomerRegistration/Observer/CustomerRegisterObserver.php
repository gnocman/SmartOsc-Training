<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Observer;

use Magento\Framework\Event\Observer;
use SmartOSC\CustomerRegistration\Helper\Email;
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
     * @param Observer $observer
     * @return null
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        return $this->helperEmail->sendEmail($customer);
    }
}
