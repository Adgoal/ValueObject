<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\NullValue;

use AdgoalCommon\ValueObject\NullValue\NullValue;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use BadMethodCallException;

class NullValueTest extends TestCase
{
    public function testFromNative(): void
    {
        $this->expectException(BadMethodCallException::class);
        NullValue::fromNative();
    }

    public function testSameValueAs(): void
    {
        $null1 = new NullValue();
        $null2 = new NullValue();

        self::assertTrue($null1->sameValueAs($null2));
    }

    public function testCreate(): void
    {
        $null = NullValue::create();

        self::assertInstanceOf(NullValue::class, $null);
    }

    public function testToString(): void
    {
        $foo = new NullValue();
        self::assertSame('', $foo->__toString());
    }
}
