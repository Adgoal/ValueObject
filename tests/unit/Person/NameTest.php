<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Person;

use AdgoalCommon\ValueObject\Person\Name;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class NameTest extends TestCase
{
    /**
     * @var Name
     */
    private $name;

    protected function setUp(): void
    {
        $this->name = new Name(new StringLiteral('foo'), new StringLiteral('bar'), new StringLiteral('baz'));
    }

    public function testFromNative(): void
    {
        $fromNativeName = Name::fromNative('foo', 'bar', 'baz');

        self::assertTrue($fromNativeName->sameValueAs($this->name));
    }

    public function testGetFirstName(): void
    {
        self::assertEquals('foo', $this->name->getFirstName());
    }

    public function testGetMiddleName(): void
    {
        self::assertEquals('bar', $this->name->getMiddleName());
    }

    public function testGetLastName(): void
    {
        self::assertEquals('baz', $this->name->getLastName());
    }

    public function testGetFullName(): void
    {
        self::assertEquals('foo bar baz', $this->name->getFullName());
    }

    public function testEmptyFullName(): void
    {
        $name = new Name(new StringLiteral(''), new StringLiteral(''), new StringLiteral(''));

        self::assertEquals('', $name->getFullName());
    }

    public function testSameValueAs(): void
    {
        $name2 = new Name(new StringLiteral('foo'), new StringLiteral('bar'), new StringLiteral('baz'));
        $name3 = new Name(new StringLiteral('foo'), new StringLiteral(''), new StringLiteral('baz'));

        self::assertTrue($this->name->sameValueAs($name2));
        self::assertTrue($name2->sameValueAs($this->name));
        self::assertFalse($this->name->sameValueAs($name3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($this->name->sameValueAs($mock));
    }

    public function testToString(): void
    {
        self::assertEquals('foo bar baz', $this->name->__toString());
    }
}
