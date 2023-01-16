<?php
/**
 * Copyright © Nam Cong, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SmartOSC\OrderManagement\Plugin\Adminhtml;

use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Backend\Block\Widget\Button\Toolbar;
use Magento\Framework\View\Element\AbstractBlock;

/**
 * Custom Button
 */
class AddCustomButton
{
    /**
     * Custom Button
     *
     * @param Toolbar $subject
     * @param AbstractBlock $context
     * @param ButtonList $buttonList
     */
    public function beforePushButtons(Toolbar $subject, AbstractBlock $context, ButtonList $buttonList): void
    {
        if ($context->getRequest()->getFullActionName() == 'sales_order_view') {
            $order_id = $context->getRequest()->getParam('order_id');
            $url = $context->getUrl('osc_order/order/index', ['order_id' => $order_id]);
            $buttonList->add(
                'customButton',
                [
                    'label' => __('Custom Button Send Email'),
                    'class' => 'send-email',
                    'onclick' => 'setLocation(\'' . $url . '\')'
                ]
            );
        }
    }
}
