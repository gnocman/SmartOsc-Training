<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use SmartOSC\CustomerRegistration\Logger\Customer;

/**
 * Log customer data (current date and time, customer first name, customer lastname, customer email)
 */
class CustomerLoginSuccess implements ObserverInterface
{
    /**
     * @var Customer
     */
    protected Customer $loggerCustomer;

    /**
     * @param Customer $loggerCustomer
     */
    public function __construct(
        Customer $loggerCustomer
    ) {
        $this->loggerCustomer = $loggerCustomer;
    }

    /**
     * Handler for 'customer_login' event.
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $observer->getEvent()->getCustomer();
        $this->loggerCustomer->info('First Name: ' . $customer->getFirstname());
        $this->loggerCustomer->info('Last Name: ' . $customer->getLastname());
        $this->loggerCustomer->info('Email: ' . $customer->getEmail());
    }
}
