<?php
/**
 * Copyright © Nam Cong, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace SmartOSC\Checkout\Observer;

use Magento\Framework\Event\Observer;

/**
 * Save data to Sale Order
 */
class SaveToOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Save data to Sale Order
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Framework\Event $event */
        $event = $observer->getEvent();
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $event->getQuote();
        /** @var \Magento\Sales\Api\Data\OrderInterface $order */
        $order = $event->getOrder();
        $order->setData('select_custom_field_hobbies', $quote->getData('select_custom_field_hobbies'));
        $order->setData('select_custom_field_income', $quote->getData('select_custom_field_income'));
    }
}
