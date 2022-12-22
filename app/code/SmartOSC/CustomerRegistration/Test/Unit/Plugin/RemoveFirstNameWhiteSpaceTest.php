<?php
declare(strict_types=1);

namespace SmartOSC\CustomerRegistration\Test\Unit\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use SmartOSC\CustomerRegistration\Plugin\RemoveFirstNameWhiteSpace;
use PHPUnit\Framework\TestCase;

/**
 * Test phpUnit whitespace first name
 */
class RemoveFirstNameWhiteSpaceTest extends TestCase
{
    /**
     * @var CustomerInterface|MockObject
     */
    public CustomerInterface|MockObject $customerMock;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->plugin = new RemoveFirstNameWhiteSpace();

        $this->customerMock = $this->createMock(CustomerInterface::class);
        $this->repositoryMock = $this->createMock(CustomerRepository::class);

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
    }

    /**
     * @return void
     */
    public function testBeforeSave(): void
    {
        $result = $this->plugin->beforeSave($this->repositoryMock, $this->customerMock);
        $this->assertEquals([$this->customerMock], $result);
    }
}
