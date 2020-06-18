<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\NullValue;

use AdgoalCommon\ValueObject\NullValue\NullValue;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class NullValueTest extends TestCase
{
    /** @expectedException \BadMethodCallException */
    public function testFromNative(): void
    {
        NullValue::fromNative();
    }

    public function testSameValueAs(): void
    {
        $null1 = new NullValue();
        $null2 = new NullValue();

        $this->assertTrue($null1->sameValueAs($null2));
    }

    public function testCreate(): void
    {
        $null = NullValue::create();

        $this->assertInstanceOf('AdgoalCommon\ValueObject\NullValue\NullValue', $null);
    }

    public function testToString(): void
    {
        $foo = new NullValue();
        $this->assertSame('', $foo->__toString());
    }
}
