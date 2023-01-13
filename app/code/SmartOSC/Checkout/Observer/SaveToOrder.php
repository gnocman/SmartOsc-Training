<?php

namespace SmartOSC\Checkout\Observer;

/**
 * Save data to Sale Order
 */
class SaveToOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Save data to Sale Order
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();
        $quote = $event->getQuote();
        $order = $event->getOrder();
        $order->setData('select_custom_field_hobbies', $quote->getData('select_custom_field_hobbies'));
        $order->setData('select_custom_field_income', $quote->getData('select_custom_field_income'));
    }
}
