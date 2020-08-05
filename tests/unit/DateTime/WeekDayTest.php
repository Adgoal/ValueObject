<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\WeekDay;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use DateTime;

class WeekDayTest extends TestCase
{
    public function testNow(): void
    {
        $weekDay = WeekDay::now();
        self::assertEquals(date('l'), $weekDay->toNative());
    }

    public function testFromNativeDateTime(): void
    {
        $nativeDateTime = new DateTime();
        $nativeDateTime->setDate(2013, 12, 14);

        $weekDay = WeekDay::fromNativeDateTime($nativeDateTime);

        self::assertEquals('Saturday', $weekDay->toNative());
    }

    public function testGetNumericValue(): void
    {
        $weekDay = WeekDay::SATURDAY();

        self::assertEquals(6, $weekDay->getNumericValue());
    }
}
