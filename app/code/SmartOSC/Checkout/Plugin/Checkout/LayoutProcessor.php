<?php
declare(strict_types=1);

namespace SmartOSC\Checkout\Plugin\Checkout;

/**
 * Add field in checkout page
 */
class LayoutProcessor
{
    /**
     * Add field in checkout page
     *
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array                                            $jsLayout
    ) {
        $validation['required-entry'] = true;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-form']['children']['select_custom_field_hobbies'] = [
            'component' => "Magento_Ui/js/form/element/select",
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => "ui/form/element/select",
                'id' => "select_custom_field_hobbies"
            ],
            'dataScope' => 'shippingAddress.select_custom_field_hobbies',
            'label' => "Customer Hobbies",
            'options' => [
                ['value' => 'Reading', 'label' => 'Reading'],
                ['value' => 'Camping', 'label' => 'Camping'],
                ['value' => 'Swimming', 'label' => 'Swimming'],
            ],
            'caption' => 'Please select',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => $validation,
            'sortOrder' => 4,
            'id' => 'select_custom_field_hobbies'
        ];

        return $jsLayout;
    }
}
