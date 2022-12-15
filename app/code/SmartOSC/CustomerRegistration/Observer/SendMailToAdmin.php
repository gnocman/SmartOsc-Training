<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Observer;

use Exception;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Send an email with the customer data to the Customer Support email address configured in Magento.
 */
class SendMailToAdmin implements ObserverInterface
{
    /**
     * customer first name, customer last name, customer email
     */
    const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_general/email';
    /**
     * @var TransportBuilder
     */
    protected TransportBuilder $_transportBuilder;
    /**
     * @var StateInterface
     */
    protected StateInterface $inlineTranslation;
    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;
    /**
     * @var Escaper
     */
    protected Escaper $_escaper;

    /**
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Escaper $escaper
     */
    public function __construct(
        TransportBuilder      $transportBuilder,
        StateInterface        $inlineTranslation,
        ScopeConfigInterface  $scopeConfig,
        StoreManagerInterface $storeManager,
        Escaper               $escaper
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $customer = $observer->getData('customer');
        $this->inlineTranslation->suspend();
        try {
            $error = false;
            $sender = [
                'firstname' => $this->_escaper->escapeHtml($customer->getFirstname()),
                'lastname' => $this->_escaper->escapeHtml($customer->getLastname()),
                'email' => $this->_escaper->escapeHtml($customer->getEmail()),
            ];
            $postObject = new DataObject();
            $postObject->setData($sender);
            $storeScope = ScopeInterface::SCOPE_STORE;
            $transport =
                $this->_transportBuilder
                    ->setTemplateIdentifier('2') // Send the ID of Email template which is created in Admin panel
                    ->setTemplateOptions(
                        ['area' => Area::AREA_FRONTEND, // using frontend area to get the template file
                            'store' => Store::DEFAULT_STORE_ID,]
                    )
                    ->setTemplateVars(['data' => $postObject])
                    ->setFrom($sender)
                    ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
                    ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (Exception $e) {
            ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->debug($e->getMessage());
        }
    }
}
