<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\StringLiteral;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Exception\InvalidNativeDataException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class StringLiteralTest extends TestCase
{
    public function testFromNative(): void
    {
        $string = StringLiteral::fromNative('foo');
        $constructedString = new StringLiteral('foo');

        self::assertTrue($string->sameValueAs($constructedString));
    }

    public function testToNative(): void
    {
        $string = new StringLiteral('foo');
        self::assertEquals('foo', $string->toNative());
    }

    public function testSameValueAs(): void
    {
        $foo1 = new StringLiteral('foo');
        $foo2 = new StringLiteral('foo');
        $bar = new StringLiteral('bar');

        self::assertTrue($foo1->sameValueAs($foo2));
        self::assertTrue($foo2->sameValueAs($foo1));
        self::assertFalse($foo1->sameValueAs($bar));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($foo1->sameValueAs($mock));
    }

    public function testInvalidNativeArgument(): void
    {
        try {
            new StringLiteral(12);
        } catch (InvalidNativeDataException $e) {
            self::assertEquals($e->getMessage(), 'Value "12" expected to be string, type integer given.');
            self::assertEquals($e->getChildClass(), StringLiteral::class);
        }
    }

    public function testIsEmpty(): void
    {
        $string = new StringLiteral('');

        self::assertTrue($string->isEmpty());
    }

    public function testToString(): void
    {
        $foo = new StringLiteral('foo');
        self::assertEquals('foo', $foo->__toString());
    }
}
