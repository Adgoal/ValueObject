<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Number;

use AdgoalCommon\ValueObject\Number\Complex;
use AdgoalCommon\ValueObject\Number\Real;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class ComplexTest extends TestCase
{
    /** @var Complex */
    private $complex;

    protected function setUp(): void
    {
        $this->complex = new Complex(new Real(2.05), new Real(3.2));
    }

    public function testFromNative(): void
    {
        $fromNativeComplex = Complex::fromNative(2.05, 3.2);

        self::assertTrue($fromNativeComplex->sameValueAs($this->complex));
    }

    public function testFromNativeWithWrongNumberOfArgsThrowsError(): void
    {
        $this->expectException('BadMethodCallException');
        Complex::fromNative(2.05);
    }

    public function testFromPolar(): void
    {
        $mod = new Real(3.800328933132);
        $arg = new Real(1.0010398733119);
        $fromPolar = Complex::fromPolar($mod, $arg);

        $nativeModulus = $this->complex->getModulus();
        $nativeArgument = $this->complex->getArgument();

        self::assertTrue($nativeModulus->sameValueAs($fromPolar->getModulus()));
        self::assertTrue($nativeArgument->sameValueAs($fromPolar->getArgument()));
    }

    public function testToNative(): void
    {
        self::assertEquals([2.05, 3.2], $this->complex->toNative());
    }

    public function testGetReal(): void
    {
        $real = new Real(2.05);

        self::assertTrue($real->sameValueAs($this->complex->getReal()));
    }

    public function testGetIm(): void
    {
        $im = new Real(3.2);

        self::assertTrue($im->sameValueAs($this->complex->getIm()));
    }

    public function testGetModulus(): void
    {
        $mod = new Real(3.800328933132);

        self::assertTrue($mod->sameValueAs($this->complex->getModulus()));
    }

    public function testGetArgument(): void
    {
        $arg = new Real(1.0010398733119);

        self::assertTrue($arg->sameValueAs($this->complex->getArgument()));
    }

    public function testToString(): void
    {
        $complex = new Complex(new Real(2.034), new Real(-1.4));
        self::assertEquals('2.034 - 1.4i', $complex->__toString());
    }

    public function testNotSameValue(): void
    {
        self::assertFalse($this->complex->sameValueAs(new Real(2.035)));
    }
}
