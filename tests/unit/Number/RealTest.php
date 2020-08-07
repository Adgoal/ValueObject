<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Number;

use AdgoalCommon\ValueObject\Number\Integer;
use AdgoalCommon\ValueObject\Number\Natural;
use AdgoalCommon\ValueObject\Number\Real;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use TypeError;

class RealTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeReal = Real::fromNative(.056);
        $constructedReal = new Real(.056);

        self::assertTrue($fromNativeReal->sameValueAs($constructedReal));
    }

    public function testToNative(): void
    {
        $real = new Real(3.4);
        self::assertEquals(3.4, $real->toNative());
    }

    public function testSameValueAs(): void
    {
        $real1 = new Real(5.64);
        $real2 = new Real(5.64);
        $real3 = new Real(6.01);

        self::assertTrue($real1->sameValueAs($real2));
        self::assertTrue($real2->sameValueAs($real1));
        self::assertFalse($real1->sameValueAs($real3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($real1->sameValueAs($mock));
    }

    public function testInvalidNativeArgument(): void
    {
        try {
            new Real('invalid');
        } catch (TypeError $error) {
            self::assertTrue(true);
        }
    }

    public function testToInteger(): void
    {
        $real = new Real(3.14);
        $nativeInteger = new Integer(3);
        $integer = $real->toInteger();

        self::assertTrue($integer->sameValueAs($nativeInteger));
    }

    public function testToNatural(): void
    {
        $real = new Real(3.14);
        $nativeNatural = new Natural(3);
        $natural = $real->toNatural();

        self::assertTrue($natural->sameValueAs($nativeNatural));
    }

    public function testToString(): void
    {
        $real = new Real(.7);
        self::assertEquals('0.7', $real->__toString());
    }
}
