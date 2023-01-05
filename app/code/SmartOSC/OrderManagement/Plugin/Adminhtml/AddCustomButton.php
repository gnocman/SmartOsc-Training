<?php
declare(strict_types=1);

namespace SmartOSC\OrderManagement\Plugin\Adminhtml;

/**
 * Custom Button
 */
class AddCustomButton
{
    /**
     * Custom Button
     *
     * @param \Magento\Backend\Block\Widget\Button\Toolbar\Interceptor $subject
     * @param \Magento\Framework\View\Element\AbstractBlock $context
     * @param \Magento\Backend\Block\Widget\Button\ButtonList $buttonList
     */
    public function beforePushButtons(
        \Magento\Backend\Block\Widget\Button\Toolbar\Interceptor $subject,
        \Magento\Framework\View\Element\AbstractBlock            $context,
        \Magento\Backend\Block\Widget\Button\ButtonList          $buttonList
    ) {
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
