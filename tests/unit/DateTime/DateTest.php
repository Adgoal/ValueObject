<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Date;
use AdgoalCommon\ValueObject\DateTime\Exception\InvalidDateException;
use AdgoalCommon\ValueObject\DateTime\Month;
use AdgoalCommon\ValueObject\DateTime\MonthDay;
use AdgoalCommon\ValueObject\DateTime\Year;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use DateTime;

class DateTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeDate = Date::fromNative(2013, 'December', 21);
        $constructedDate = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(21));

        self::assertTrue($fromNativeDate->sameValueAs($constructedDate));
    }

    public function testFromNativeDateTime(): void
    {
        $nativeDate = new DateTime();
        $nativeDate->setDate(2013, 12, 3);
        $dateFromNative = Date::fromNativeDateTime($nativeDate);
        $constructedDate = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));

        self::assertTrue($dateFromNative->sameValueAs($constructedDate));
    }

    public function testNow(): void
    {
        $date = Date::now();
        self::assertEquals(date('Y-n-j'), (string) $date);
    }

    public function testAlmostValidDateException(): void
    {
        $exception = new InvalidDateException(2013, 02, 31);
        $this->expectExceptionObject($exception);
        new Date(new Year(2013), Month::FEBRUARY(), new MonthDay(31));
    }

    public function testSameValueAs(): void
    {
        $date1 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $date2 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $date3 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(5));

        self::assertTrue($date1->sameValueAs($date2));
        self::assertTrue($date2->sameValueAs($date1));
        self::assertFalse($date1->sameValueAs($date3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($date1->sameValueAs($mock));
    }

    public function testGetYear(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $year = new Year(2013);

        self::assertTrue($year->sameValueAs($date->getYear()));
    }

    public function testGetMonth(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $month = Month::DECEMBER();

        self::assertTrue($month->sameValueAs($date->getMonth()));
    }

    public function testGetDay(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $day = new MonthDay(3);

        self::assertTrue($day->sameValueAs($date->getDay()));
    }

    public function testToNativeDateTime(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $nativeDate = DateTime::createFromFormat('Y-n-j H:i:s', '2013-12-3 00:00:00');

        self::assertEquals($nativeDate, $date->toNativeDateTime());
    }

    public function testToString(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        self::assertEquals('2013-12-3', $date->__toString());
    }
}
