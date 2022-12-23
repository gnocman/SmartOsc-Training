<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Test\Unit\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use SmartOSC\CustomerRegistration\Plugin\RemoveFirstNameWhiteSpace;
use PHPUnit\Framework\TestCase;

class RemoveFirstNameWhiteSpaceTest extends TestCase
{
    /**
     * @var CustomerInterface|MockObject
     */
    protected $customerMock;

    /**
     * @var CustomerRepository|MockObject
     */
    protected $repositoryMock;

    /**
     * @var RemoveFirstNameWhiteSpace
     */
    protected $plugin;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->customerMock = $this->createMock(CustomerInterface::class);
        $this->repositoryMock = $this->createMock(CustomerRepository::class);
        $this->plugin = new RemoveFirstNameWhiteSpace();
    }

    /**
     * @return void
     */
    public function testBeforeSaveNewCustomer(): void
    {
        $this->customerMock->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->customerMock->expects($this->once())
            ->method('getFirstName')
            ->willReturn('John Doe');

        $this->customerMock->expects($this->once())
            ->method('setFirstName')
            ->with('JohnDoe')
            ->willReturnSelf();

        $result = $this->plugin->beforeSave($this->repositoryMock, $this->customerMock);
        $this->assertEquals([$this->customerMock], $result);
    }

    /**
     * @return void
     */
    public function testBeforeSaveExistingCustomer(): void
    {
        $this->customerMock->expects($this->once())
            ->method('getId')
            ->willReturn(123);

        $this->customerMock->expects($this->never())
            ->method('getFirstName');

        $this->customerMock->expects($this->never())
            ->method('setFirstName');

        $result = $this->plugin->beforeSave($this->repositoryMock, $this->customerMock);
        $this->assertEquals([$this->customerMock], $result);
    }
}
