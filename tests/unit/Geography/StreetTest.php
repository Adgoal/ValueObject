<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Street;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use BadMethodCallException;

class StreetTest extends TestCase
{
    /**
     * @var Street
     */
    protected $street;

    protected function setUp(): void
    {
        $this->street = new Street(new StringLiteral('Abbey Rd'), new StringLiteral('3'), new StringLiteral('Building A'), new StringLiteral('%number% %name%, %elements%'));
    }

    public function testFromNative(): void
    {
        $fromNativeStreet = Street::fromNative('Abbey Rd', '3', 'Building A');
        self::assertTrue($this->street->sameValueAs($fromNativeStreet));
    }

    public function testInvalidFromNative(): void
    {
        $this->expectException(BadMethodCallException::class);
        Street::fromNative('Abbey Rd');
    }

    public function testSameValueAs(): void
    {
        $street2 = new Street(new StringLiteral('Abbey Rd'), new StringLiteral('3'), new StringLiteral('Building A'));
        $street3 = new Street(new StringLiteral('Orchard Road'), new StringLiteral(''));

        self::assertTrue($this->street->sameValueAs($street2));
        self::assertTrue($street2->sameValueAs($this->street));
        self::assertFalse($this->street->sameValueAs($street3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($this->street->sameValueAs($mock));
    }

    public function testGetName(): void
    {
        $name = new StringLiteral('Abbey Rd');
        self::assertTrue($this->street->getName()->sameValueAs($name));
    }

    public function testGetNumber(): void
    {
        $number = new StringLiteral('3');
        self::assertTrue($this->street->getNumber()->sameValueAs($number));
    }

    public function testGetElements(): void
    {
        $elements = new StringLiteral('Building A');
        self::assertTrue($this->street->getElements()->sameValueAs($elements));
    }

    public function testToString(): void
    {
        self::assertSame('3 Abbey Rd, Building A', $this->street->__toString());
    }
}
