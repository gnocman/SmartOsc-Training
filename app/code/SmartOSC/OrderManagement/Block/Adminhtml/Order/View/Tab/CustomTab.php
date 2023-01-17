<?php
/**
 * Copyright © Nam Cong, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace SmartOSC\OrderManagement\Block\Adminhtml\Order\View\Tab;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;

/**
 * Custom tab html
 */
class CustomTab extends Template implements TabInterface
{
    /**
     * @var string
     */
    protected $_template = 'SmartOSC_OrderManagement::order/view/tab/customTab.phtml';
    /**
     * @var Registry
     */
    private Registry $_coreRegistry;

    /**
     * View constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context  $context,
        Registry $registry,
        array    $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve order model instance
     *
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->_coreRegistry->registry('current_order');
    }

    /**
     * Retrieve order increment id
     *
     * @return string
     */
    public function getOrderIncrementId(): string
    {
        return $this->getOrder()->getIncrementId();
    }

    /**
     * Retrieve order Select Custom Field Hobbies
     *
     * @return mixed
     */
    public function getOrderSelectCustomFieldHobbies(): mixed
    {
        return $this->getOrder()->getSelectCustomFieldHobbies();
    }

    /**
     * Retrieve order Select Custom Field Income
     *
     * @return mixed
     */
    public function getOrderSelectCustomFieldIncome(): mixed
    {
        return $this->getOrder()->getSelectCustomFieldIncome();
    }

    /**
     * @inheritdoc
     */
    public function getTabLabel(): \Magento\Framework\Phrase|string
    {
        return __('Customer Survey');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle(): \Magento\Framework\Phrase|string
    {
        return __('Customer Survey');
    }

    /**
     * @inheritdoc
     */
    public function canShowTab(): bool
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isHidden(): bool
    {
        return false;
    }
}
