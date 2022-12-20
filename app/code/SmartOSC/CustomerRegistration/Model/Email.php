<?php
/** @noinspection PhpCSValidationInspection */
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Model;

use Exception;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Area;
use Magento\Framework\Model\Context;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Send email when customer registration account
 */
class Email
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
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param Context $context
     * @param StateInterface $inlineTranslation
     * @param Escaper $escaper
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context              $context,
        StateInterface       $inlineTranslation,
        Escaper              $escaper,
        TransportBuilder     $transportBuilder,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Send email when customer registration account
     *
     * @param CustomerInterface $customer
     * @return void
     */
    public function sendEmail(CustomerInterface $customer): void
    {
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Test'),
                'email' => $this->escaper->escapeHtml('giochem22@gmail.com'),
            ];
            $templateId = $this->scopeConfig->getValue(
                'email/demo/template',
                ScopeInterface::SCOPE_STORE
            );
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($templateId)
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'templateVar' => 'First Name: ' . $customer->getFirstname() .
                        'Last Name: ' . $customer->getLastname() .
                        'Email: ' . $customer->getEmail(),
                ])
                ->setFrom($sender)
                ->addTo('giochem22@gmail.com')
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
