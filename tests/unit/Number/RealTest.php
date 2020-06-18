<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Number;

use AdgoalCommon\ValueObject\Number\Integer;
use AdgoalCommon\ValueObject\Number\Natural;
use AdgoalCommon\ValueObject\Number\Real;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class RealTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeReal = Real::fromNative(.056);
        $constructedReal = new Real(.056);

        $this->assertTrue($fromNativeReal->sameValueAs($constructedReal));
    }

    public function testToNative(): void
    {
        $real = new Real(3.4);
        $this->assertEquals(3.4, $real->toNative());
    }

    public function testSameValueAs(): void
    {
        $real1 = new Real(5.64);
        $real2 = new Real(5.64);
        $real3 = new Real(6.01);

        $this->assertTrue($real1->sameValueAs($real2));
        $this->assertTrue($real2->sameValueAs($real1));
        $this->assertFalse($real1->sameValueAs($real3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($real1->sameValueAs($mock));
    }

    public function testToInteger(): void
    {
        $real = new Real(3.14);
        $nativeInteger = new Integer(3);
        $integer = $real->toInteger();

        $this->assertTrue($integer->sameValueAs($nativeInteger));
    }

    public function testToNatural(): void
    {
        $real = new Real(3.14);
        $nativeNatural = new Natural(3);
        $natural = $real->toNatural();

        $this->assertTrue($natural->sameValueAs($nativeNatural));
    }

    public function testToString(): void
    {
        $real = new Real(.7);
        $this->assertEquals('0.7', $real->__toString());
    }

    public function testInvalidReal(): void
    {
        $this->expectException(\TypeError::class);

        new Real('invalid');
    }
}
