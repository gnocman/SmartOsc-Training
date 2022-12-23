<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Test\Unit\Observer;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Event\Observer;
use SmartOSC\CustomerRegistration\Model\Email;
use SmartOSC\CustomerRegistration\Observer\CustomerRegisterObserver;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CustomerRegisterObserverTest extends TestCase
{
    /**
     * @var CustomerInterface|MockObject
     */
    protected $customerMock;

    /**
     * @var Email|MockObject
     */
    protected $helperEmailMock;

    /**
     * @var Observer|MockObject
     */
    protected $observerMock;

    /**
     * @var CustomerRegisterObserver
     */
    protected $observer;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->customerMock = $this->createMock(CustomerInterface::class);
        $this->helperEmailMock = $this->createMock(Email::class);
        $this->observerMock = $this->createMock(Observer::class);

        $this->observerMock->expects($this->once())
            ->method('getEvent')
            ->willReturnSelf();

        $this->observerMock->expects($this->once())
            ->method('getData')
            ->with('customer')
            ->willReturn($this->customerMock);

        $this->observer = new CustomerRegisterObserver($this->helperEmailMock);
    }

    /**
     * @return void
     */
    public function testExecute(): void
    {
        $this->helperEmailMock->expects($this->once())
            ->method('sendEmail')
            ->with($this->customerMock);

        $this->observer->execute($this->observerMock);
    }
}
