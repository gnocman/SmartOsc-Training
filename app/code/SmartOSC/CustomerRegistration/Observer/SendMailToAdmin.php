<?php

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

class SendMailToAdmin implements ObserverInterface
{
    const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_general/email';
    protected TransportBuilder $_transportBuilder;
    protected StateInterface $inlineTranslation;
    protected ScopeConfigInterface $scopeConfig;
    protected StoreManagerInterface $storeManager;
    protected Escaper $_escaper;

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

    public function execute(Observer $observer)
    {
        $customer = $observer->getData('customer');
        $this->inlineTranslation->suspend();
        try {
            $error = false;
            $sender = [
                'name' => $this->_escaper->escapeHtml($customer->getFirstName()),
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
                    ->setTemplateVars(['customer' => $postObject])
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
