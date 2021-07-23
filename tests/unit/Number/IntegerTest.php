<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Number;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Exception\InvalidNativeDataException;
use AdgoalCommon\ValueObject\Number\Integer;
use AdgoalCommon\ValueObject\Number\Real;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use TypeError;

class IntegerTest extends TestCase
{
    public function testToNative(): void
    {
        $integer = new Integer(5);
        self::assertSame(5, $integer->toNative());
    }

    public function testSameValueAs(): void
    {
        $integer1 = new Integer(3);
        $integer2 = new Integer(3);
        $integer3 = new Integer(45);

        self::assertTrue($integer1->sameValueAs($integer2));
        self::assertTrue($integer2->sameValueAs($integer1));
        self::assertFalse($integer1->sameValueAs($integer3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($integer1->sameValueAs($mock));
    }

    public function testToString(): void
    {
        $integer = new Integer(87);
        self::assertSame('87', $integer->__toString());
    }

    public function testInvalidNativeArgument(): void
    {
        try {
            new Integer(23.4);
        } catch (InvalidNativeArgumentException $e) {
            self::assertEquals($e->getMessage(), 'Argument "" is invalid. Allowed types for argument are "int".');
            self::assertEquals($e->getChildClass(), Integer::class);
        }
    }

    public function testZeroToString(): void
    {
        $zero = new Integer(0);
        self::assertSame('0', $zero->__toString());
    }

    public function testToReal(): void
    {
        $integer = new Integer(5);
        $nativeReal = new Real(5);
        $real = $integer->toReal();

        self::assertTrue($real->sameValueAs($nativeReal));
    }
}
