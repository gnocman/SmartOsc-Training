<?php
declare(strict_types=1);

namespace SmartOSC\OrderManagement\Block\Adminhtml\Order\View\Tab;

/**
 * Custom tab html
 */
class CustomTab extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var string
     */
    protected $_template = 'SmartOSC_OrderManagement::order/view/tab/customTab.phtml';
    /**
     * @var \Magento\Framework\Registry
     */
    private $_coreRegistry;

    /**
     * View constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        array                                   $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    /**
     * Retrieve order increment id
     *
     * @return string
     */
    public function getOrderIncrementId()
    {
        return $this->getOrder()->getIncrementId();
    }

    /**
     * Retrieve order Select Custom Field Hobbies
     *
     * @return string
     */
    public function getOrderSelectCustomFieldHobbies()
    {
        return $this->getOrder()->getSelectCustomFieldHobbies();
    }

    /**
     * @inheritdoc
     */
    public function getTabLabel()
    {
        return __('Customer Survey');
    }

    /**
     * @inheritdoc
     */
    public function getTabTitle()
    {
        return __('Customer Survey');
    }

    /**
     * @inheritdoc
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isHidden()
    {
        return false;
    }
}
