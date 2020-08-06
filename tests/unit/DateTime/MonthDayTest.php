<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\MonthDay;
use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class MonthDayTest extends TestCase
{
    public function fromNative(): void
    {
        $fromNativeMonthDay = MonthDay::fromNative(15);
        $constructedMonthDay = new MonthDay(15);

        self::assertTrue($fromNativeMonthDay->sameValueAs($constructedMonthDay));
    }

    public function testNow(): void
    {
        $monthDay = MonthDay::now();
        self::assertEquals(date('j'), $monthDay->toNative());
    }

    public function testInvalidMonthDay(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new MonthDay(32);
    }
}
