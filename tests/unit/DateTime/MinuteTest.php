<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Minute;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class MinuteTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeMinute = Minute::fromNative(11);
        $constructedMinute = new Minute(11);

        $this->assertTrue($fromNativeMinute->sameValueAs($constructedMinute));
    }

    public function testNow(): void
    {
        $minute = Minute::now();
        $this->assertEquals(intval(date('i')), $minute->toNative());
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidMinute(): void
    {
        new Minute(60);
    }
}
