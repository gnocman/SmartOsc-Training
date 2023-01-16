<?php
/**
 * Copyright © Nam Cong, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

/**
 * Event log info customer when register
 */
class CustomerLoginSuccess implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * LogCustomerData constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Event log info customer when register
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $customer = $observer->getEvent()->getCustomer();

        $data = [
            'current_date_time' => date('Y-m-d H:i:s'),
            'first_name' => $customer->getFirstname(),
            'last_name' => $customer->getLastname(),
            'email' => $customer->getEmail(),
        ];

        $this->logger->info(json_encode($data));
    }
}
