<?php
/**
 * Copyright © Nam Cong, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace SmartOSC\Checkout\Controller\Quote;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Save data custom to database
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var QuoteIdMaskFactory
     */
    protected QuoteIdMaskFactory $quoteIdMaskFactory;
    /**
     * @var CartRepositoryInterface
     */
    protected CartRepositoryInterface $quoteRepository;

    /**
     * @param Context $context
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param CartRepositoryInterface $quoteRepository
     */
    public function __construct(
        Context                 $context,
        QuoteIdMaskFactory      $quoteIdMaskFactory,
        CartRepositoryInterface $quoteRepository
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
        $post = $this->getRequest()->getParams();
        if ($post) {
            $cartId = $post['cartId'];
            $hobbies = $post['select_custom_field_hobbies'];
            $income = $post['select_custom_field_income'];
            $login = $post['is_customer'];

            if ($login === 'false') {
                $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
            }

            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }

            $quote->setData('select_custom_field_hobbies', $hobbies);
            $quote->setData('select_custom_field_income', $income);
            $this->quoteRepository->save($quote);
        }
    }
}
