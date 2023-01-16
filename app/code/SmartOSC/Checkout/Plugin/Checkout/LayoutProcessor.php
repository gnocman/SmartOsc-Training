<?php
/**
 * Copyright © Nam Cong, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

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
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, array $jsLayout): array
    {
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

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-form']['children']['select_custom_field_income'] = [
            'component' => "Magento_Ui/js/form/element/select",
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => "ui/form/element/select",
                'id' => "select_custom_field_income"
            ],
            'dataScope' => 'shippingAddress.select_custom_field_income',
            'label' => "Customer Income",
            'options' => [
                ['value' => '100$ ~ 200$/week', 'label' => '100$ ~ 200$/week'],
                ['value' => '200$ ~ 300$/week', 'label' => '200$ ~ 300$/week'],
                ['value' => '300$ ~ 400$/week', 'label' => '300$ ~ 400$/week'],
            ],
            'caption' => 'Please select',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => $validation,
            'sortOrder' => 5,
            'id' => 'select_custom_field_income'
        ];

        return $jsLayout;
    }
}
