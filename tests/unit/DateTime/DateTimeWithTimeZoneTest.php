<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Date;
use AdgoalCommon\ValueObject\DateTime\DateTime;
use AdgoalCommon\ValueObject\DateTime\DateTimeWithTimeZone;
use AdgoalCommon\ValueObject\DateTime\Hour;
use AdgoalCommon\ValueObject\DateTime\Minute;
use AdgoalCommon\ValueObject\DateTime\Month;
use AdgoalCommon\ValueObject\DateTime\MonthDay;
use AdgoalCommon\ValueObject\DateTime\Second;
use AdgoalCommon\ValueObject\DateTime\Time;
use AdgoalCommon\ValueObject\DateTime\TimeZone;
use AdgoalCommon\ValueObject\DateTime\Year;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use DateTimeZone;

class DateTimeWithTimeZoneTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeDateTimeWithTz = DateTimeWithTimeZone::fromNative(2013, 'December', 21, 10, 20, 34, 'Europe/Madrid');
        $constructedDateTimeWithTz = new DateTimeWithTimeZone(
            new DateTime(
                new Date(new Year(2013), Month::DECEMBER(), new MonthDay(21)),
                new Time(new Hour(10), new Minute(20), new Second(34))
            ),
            new TimeZone(new StringLiteral('Europe/Madrid'))
        );

        self::assertTrue($fromNativeDateTimeWithTz->sameValueAs($constructedDateTimeWithTz));
    }

    public function testFromNativeDateTime(): void
    {
        $nativeDateTime = new \DateTime();
        $nativeDateTime->setTimeZone(new DateTimeZone('Europe/Madrid'))->setDate(2013, 12, 6)->setTime(20, 50, 10);
        $dateTimeWithTzFromNative = DateTimeWithTimeZone::fromNativeDateTime($nativeDateTime);

        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(6));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $timezone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $constructedDateTimeWithTz = new DateTimeWithTimeZone(new DateTime($date, $time), $timezone);

        self::assertTrue($dateTimeWithTzFromNative->sameValueAs($constructedDateTimeWithTz));
    }

    public function testNow(): void
    {
        $dateTimeWithTz = DateTimeWithTimeZone::now();
        self::assertEquals(date('Y-n-j G:i:s e'), (string) $dateTimeWithTz);
    }

    public function testSameValueAs(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $date3 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time3 = new Time(new Hour(20), new Minute(50), new Second(10));
        $timeZone3 = new TimeZone(new StringLiteral('Europe/London'));

        $dateTimeWithTz1 = new DateTimeWithTimeZone(new DateTime($date, $time), $timeZone);
        $dateTimeWithTz2 = new DateTimeWithTimeZone(new DateTime($date, $time), $timeZone);
        $dateTimeWithTz3 = new DateTimeWithTimeZone(new DateTime($date3, $time3), $timeZone3);

        self::assertTrue($dateTimeWithTz1->sameValueAs($dateTimeWithTz2));
        self::assertTrue($dateTimeWithTz2->sameValueAs($dateTimeWithTz1));
        self::assertFalse($dateTimeWithTz1->sameValueAs($dateTimeWithTz3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($dateTimeWithTz1->sameValueAs($mock));
    }

    public function testSameTimestampAs(): void
    {
        $date1 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time1 = new Time(new Hour(20), new Minute(50), new Second(10));
        $timeZone1 = new TimeZone(new StringLiteral('Europe/Madrid'));

        $date2 = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time2 = new Time(new Hour(19), new Minute(50), new Second(10));
        $timeZone2 = new TimeZone(new StringLiteral('Europe/London'));

        $dateTimeWithTz1 = new DateTimeWithTimeZone(new DateTime($date1, $time1), $timeZone1);
        $dateTimeWithTz2 = new DateTimeWithTimeZone(new DateTime($date2, $time2), $timeZone2);

        self::assertTrue($dateTimeWithTz1->sameTimestampAs($dateTimeWithTz2));
        self::assertFalse($dateTimeWithTz1->sameValueAs($dateTimeWithTz2));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($dateTimeWithTz1->sameTimestampAs($mock));
    }

    public function testGetDateTime(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $dateTimeWithTz = new DateTimeWithTimeZone($dateTime, $timeZone);

        self::assertTrue($dateTime->sameValueAs($dateTimeWithTz->getDateTime()));
    }

    public function testGetTimeZone(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $dateTimeWithTz = new DateTimeWithTimeZone($dateTime, $timeZone);

        self::assertTrue($timeZone->sameValueAs($dateTimeWithTz->getTimeZone()));
    }

    public function testToNativeDateTime(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $dateTimeWithTz = new DateTimeWithTimeZone($dateTime, $timeZone);
        $nativeDateTime = \DateTime::createFromFormat('Y-n-j H:i:s e', '2013-12-3 20:50:10 Europe/Madrid');

        self::assertEquals($nativeDateTime, $dateTimeWithTz->toNativeDateTime());
    }

    public function testToString(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));
        $dateTimeWithTz = new DateTimeWithTimeZone($dateTime, $timeZone);

        self::assertEquals('2013-12-3 20:50:10 Europe/Madrid', $dateTimeWithTz->__toString());
    }
}
