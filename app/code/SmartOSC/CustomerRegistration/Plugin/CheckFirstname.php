<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Plugin;

use Magento\Customer\Controller\Account\CreatePost;

/**
 * Once a new customer is being registered, the extension checks the First Name field
 */
class CheckFirstname
{
    /**
     * @param CreatePost $subject
     * @return void
     */
    public function beforeExecute(CreatePost $subject): void
    {
        $firstName = $subject->getRequest()->getParam('firstname');
        $subject->getRequest()->setParam('firstname', str_replace(' ', '', $firstName));
    }
}
