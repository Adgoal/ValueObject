<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\MonthDay;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class MonthDayTest extends TestCase
{
    public function fromNative(): void
    {
        $fromNativeMonthDay = MonthDay::fromNative(15);
        $constructedMonthDay = new MonthDay(15);

        $this->assertTrue($fromNativeMonthDay->sameValueAs($constructedMonthDay));
    }

    public function testNow(): void
    {
        $monthDay = MonthDay::now();
        $this->assertEquals(date('j'), $monthDay->toNative());
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidMonthDay(): void
    {
        new MonthDay(32);
    }
}
