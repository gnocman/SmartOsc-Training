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
            [1, 'John Doe', 'JohnDoe'],
            [null, 'Jane  Doe', 'JaneDoe'],
            [2, ' Jack Smith', 'JackSmith'],
            [3, 'Mary  Jane ', 'MaryJane'],
        ];
    }

    /**
     * @dataProvider beforeSaveProvider
     *
     * @param ?int $id
     * @param string $firstName
     * @param string $expectedFirstName
     */
    public function testBeforeSave(?int $id, string $firstName, string $expectedFirstName): void
    {
        $id = 1;
        $this->customerMock->expects($this->any())
            ->method('getId')
            ->willReturn($id);

//        $this->customerMock->expects(($id != null) ? self::once() : $this->any())
//            ->method('getFirstName')
//            ->willReturn($firstName);

        $this->customerMock->expects(($id != null) ? self::once() : $this->any())
            ->method('setFirstName');

        $result = $this->plugin->beforeSave($this->repositoryMock, $this->customerMock);

        $this->assertEquals($result[0]->getFirstname(), $expectedFirstName);
    }
}
