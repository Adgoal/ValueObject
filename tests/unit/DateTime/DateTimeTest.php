<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Date;
use AdgoalCommon\ValueObject\DateTime\DateTime;
use AdgoalCommon\ValueObject\DateTime\Hour;
use AdgoalCommon\ValueObject\DateTime\Minute;
use AdgoalCommon\ValueObject\DateTime\Month;
use AdgoalCommon\ValueObject\DateTime\MonthDay;
use AdgoalCommon\ValueObject\DateTime\Second;
use AdgoalCommon\ValueObject\DateTime\Time;
use AdgoalCommon\ValueObject\DateTime\Year;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class DateTimeTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeDateTime = DateTime::fromNative(2013, 'December', 21, 10, 20, 34);
        $constructedDateTime = new DateTime(
                                    new Date(new Year(2013), Month::DECEMBER(), new MonthDay(21)),
                                    new Time(new Hour(10), new Minute(20), new Second(34))
                               );

        $this->assertTrue($fromNativeDateTime->sameValueAs($constructedDateTime));
    }

    public function testFromNativeDateTime(): void
    {
        $nativeDateTime = new \DateTime();
        $nativeDateTime->setDate(2013, 12, 6)->setTime(20, 50, 10);
        $dateTimeFromNative = DateTime::fromNativeDateTime($nativeDateTime);

        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(6));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $constructedDateTime = new DateTime($date, $time);

        $this->assertTrue($dateTimeFromNative->sameValueAs($constructedDateTime));
    }

    public function testNow(): void
    {
        $dateTime = DateTime::now();
        $this->assertEquals(date('Y-n-j G:i:s'), (string) $dateTime);
    }

    public function testNullTime(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(21));
        $dateTime = new DateTime($date);
        $this->assertTrue(Time::zero()->sameValueAs($dateTime->getTime()));
    }

    public function testSameValueAs(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));

        $date3 = new Date(new Year(2014), Month::MARCH(), new MonthDay(5));
        $time3 = new Time(new Hour(10), new Minute(52), new Second(40));

        $dateTime1 = new DateTime($date, $time);
        $dateTime2 = new DateTime($date, $time);
        $dateTime3 = new DateTime($date3, $time3);

        $this->assertTrue($dateTime1->sameValueAs($dateTime2));
        $this->assertTrue($dateTime2->sameValueAs($dateTime1));
        $this->assertFalse($dateTime1->sameValueAs($dateTime3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($dateTime1->sameValueAs($mock));
    }

    public function testGetDate(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);

        $this->assertTrue($date->sameValueAs($dateTime->getDate()));
    }

    public function testGetTime(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);

        $this->assertTrue($time->sameValueAs($dateTime->getTime()));
    }

    public function testToNativeDateTime(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);
        $nativeDateTime = \DateTime::createFromFormat('Y-n-j H:i:s', '2013-12-3 20:50:10');

        $this->assertEquals($nativeDateTime, $dateTime->toNativeDateTime());
    }

    public function testToString(): void
    {
        $date = new Date(new Year(2013), Month::DECEMBER(), new MonthDay(3));
        $time = new Time(new Hour(20), new Minute(50), new Second(10));
        $dateTime = new DateTime($date, $time);

        $this->assertEquals('2013-12-3 20:50:10', $dateTime->__toString());
    }
}
