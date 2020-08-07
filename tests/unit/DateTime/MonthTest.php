<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Month;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use DateTime;

class MonthTest extends TestCase
{
    public function testNow(): void
    {
        $month = Month::now();
        self::assertEquals(date('F'), $month->toNative());
    }

    public function testFromNativeDateTime(): void
    {
        $nativeDateTime = new DateTime();
        $nativeDateTime->setDate(2013, 12, 1);

        $month = Month::fromNativeDateTime($nativeDateTime);

        self::assertEquals('December', $month->toNative());
    }

    public function testGetNumericValue(): void
    {
        $month = Month::APRIL();

        self::assertEquals(4, $month->getNumericValue());
    }
}
