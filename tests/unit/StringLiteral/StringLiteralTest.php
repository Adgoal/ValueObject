<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\StringLiteral;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class StringLiteralTest extends TestCase
{
    public function testFromNative(): void
    {
        $string = StringLiteral::fromNative('foo');
        $constructedString = new StringLiteral('foo');

        $this->assertTrue($string->sameValueAs($constructedString));
    }

    public function testToNative(): void
    {
        $string = new StringLiteral('foo');
        $this->assertEquals('foo', $string->toNative());
    }

    public function testSameValueAs(): void
    {
        $foo1 = new StringLiteral('foo');
        $foo2 = new StringLiteral('foo');
        $bar = new StringLiteral('bar');

        $this->assertTrue($foo1->sameValueAs($foo2));
        $this->assertTrue($foo2->sameValueAs($foo1));
        $this->assertFalse($foo1->sameValueAs($bar));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($foo1->sameValueAs($mock));
    }

    /** @expectedException \AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidNativeArgument(): void
    {
        new StringLiteral(12);
    }

    public function testIsEmpty(): void
    {
        $string = new StringLiteral('');

        $this->assertTrue($string->isEmpty());
    }

    public function testToString(): void
    {
        $foo = new StringLiteral('foo');
        $this->assertEquals('foo', $foo->__toString());
    }
}
