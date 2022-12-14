<?php

namespace SmartOSC\CustomerRegistration\Logger\Handler;

use Magento\Framework\Filesystem\DriverInterface;

class Customer extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;

    /**
     * @param DriverInterface $filesystem
     * @param $filePath
     * @param $fileName
     */
    public function __construct(
        DriverInterface $filesystem,
                        $filePath = null,
                        $fileName = null
    ) {
        $fileName = '/var/log/customer-' . date('Y-m-d') . '.log';
        parent::__construct($filesystem, $filePath, $fileName);
    }
}
