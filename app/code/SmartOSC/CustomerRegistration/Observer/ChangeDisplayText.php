<?php

namespace SmartOSC\CustomerRegistration\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * The customer entity is saved without whitespaces in the First Name property
 */
class ChangeDisplayText implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     * @throws \Zend_Log_Exception
     */
    public function execute(Observer $observer)
    {
        $displayText = $observer->getData('customer');
        $displayText->setData('firstname', str_replace(' ', '', $displayText->getFirstname()));

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('First name' . ': ' . $observer->getData('customer')->getFirstname());
        $logger->info('Last name' . ': ' . $observer->getData('customer')->getLastname());
        $logger->info('Email' . ': ' . $observer->getData('customer')->getEmail());
    }
}
