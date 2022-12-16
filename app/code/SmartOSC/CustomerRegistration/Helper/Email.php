<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Psr\Log\LoggerInterface;

/**
 * Send email when customer registration account
 */
class Email extends AbstractHelper
{
    /**
     * @var StateInterface
     */
    protected StateInterface $inlineTranslation;
    /**
     * @var Escaper
     */
    protected Escaper $escaper;
    /**
     * @var TransportBuilder
     */
    protected TransportBuilder $transportBuilder;
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param Context $context
     * @param StateInterface $inlineTranslation
     * @param Escaper $escaper
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(
        Context          $context,
        StateInterface   $inlineTranslation,
        Escaper          $escaper,
        TransportBuilder $transportBuilder
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
    }

    /**
     * @return void
     */
    public function sendEmail($customer)
    {
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Test'),
                'email' => $this->escaper->escapeHtml('giochem22@gmail.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('email_demo_template')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'templateVar' => 'First Name: ' . $customer->getFirstname() .
                        'Last Name: ' . $customer->getLastname() .
                        'Email: ' . $customer->getEmail(),
                ])
                ->setFrom($sender)
                ->addTo($customer->getEmail())
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
