<?php

namespace SmartOSC\CustomerRegistration\Plugin;

use Magento\Customer\Controller\Account\CreatePost;

class CheckFirstname
{
    public function beforeExecute(CreatePost $subject): void
    {
        $firstName = $subject->getRequest()->getParam('firstname');
        $subject->getRequest()->setParam('firstname', str_replace(' ', '', $firstName));
    }
}
