<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Logger\Handler;

use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Log file in the var/log directory
 */
class Customer extends Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * @param DriverInterface $filesystem
     * @param $filePath
     */
    public function __construct(
        DriverInterface $filesystem,
                        $filePath = null
    ) {
        $fileName = '/var/log/customer-' . date('Y-m-d') . '.log';
        parent::__construct($filesystem, $filePath, $fileName);
    }
}
