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
    protected CustomerInterface|MockObject $customerMock;

    /**
     * @var CustomerRepository|MockObject
     */
    protected MockObject|CustomerRepository $repositoryMock;

    /**
     * @var RemoveFirstNameWhiteSpace
     */
    protected RemoveFirstNameWhiteSpace $plugin;

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
     * @return array
     */
    public function beforeSaveProvider(): array
    {
        return [
            ['John Doe', 'JohnDoe'],
            ['Jane  Doe', 'JaneDoe'],
            [' Jack Smith', 'JackSmith'],
            ['Mary  Jane ', 'MaryJane'],
        ];
    }

    /**
     * @dataProvider beforeSaveProvider
     * @param string $firstName
     * @param string $expectedFirstName
     */
    public function testBeforeSave(string $firstName, string $expectedFirstName): void
    {
        $this->customerMock->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->customerMock->expects($this->once())
            ->method('getFirstName')
            ->willReturn($firstName);

        $this->customerMock->expects($this->once())
            ->method('setFirstName')
            ->with($expectedFirstName)
            ->willReturnSelf();

        $result = $this->plugin->beforeSave($this->repositoryMock, $this->customerMock);
        $this->assertEquals([$this->customerMock], $result);
    }
}
