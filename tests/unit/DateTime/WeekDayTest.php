<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\WeekDay;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class WeekDayTest extends TestCase
{
    public function testNow(): void
    {
        $weekDay = WeekDay::now();
        $this->assertEquals(date('l'), $weekDay->toNative());
    }

    public function testFromNativeDateTime(): void
    {
        $nativeDateTime = new \DateTime();
        $nativeDateTime->setDate(2013, 12, 14);

        $weekDay = WeekDay::fromNativeDateTime($nativeDateTime);

        $this->assertEquals('Saturday', $weekDay->toNative());
    }

    public function testGetNumericValue(): void
    {
        $weekDay = WeekDay::SATURDAY();

        $this->assertEquals(6, $weekDay->getNumericValue());
    }
}
