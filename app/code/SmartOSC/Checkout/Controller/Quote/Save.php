<?php

namespace SmartOSC\Checkout\Controller\Quote;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Save data custom to database
 */
class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Quote\Model\QuoteIdMaskFactory
     */
    protected $quoteIdMaskFactory;
    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context      $context,
        \Magento\Quote\Model\QuoteIdMaskFactory    $quoteIdMaskFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        parent::__construct($context);
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
    }

    /**
     * Save data custom to database
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        if ($post) {
            $cartId = $post['cartId'];
            $hobbies = $post['select_custom_field_hobbies'];
            $login = $post['is_customer'];

            if ($login === 'false') {
                $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
            }

            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }

            $quote->setData('select_custom_field_hobbies', $hobbies);
            $this->quoteRepository->save($quote);
        }
    }
}
