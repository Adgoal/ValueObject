<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Hour;
use AdgoalCommon\ValueObject\DateTime\Minute;
use AdgoalCommon\ValueObject\DateTime\Second;
use AdgoalCommon\ValueObject\DateTime\Time;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use DateTime;

class TimeTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeTime = Time::fromNative(10, 4, 50);
        $constructedTime = new Time(new Hour(10), new Minute(4), new Second(50));

        self::assertTrue($fromNativeTime->sameValueAs($constructedTime));
    }

    public function testFromNativeDateTime(): void
    {
        $nativeTime = new DateTime();
        $nativeTime->setTime(20, 10, 34);
        $timeFromNative = Time::fromNativeDateTime($nativeTime);
        $constructedTime = new Time(new Hour(20), new Minute(10), new Second(34));

        self::assertTrue($timeFromNative->sameValueAs($constructedTime));
    }

    public function testNow(): void
    {
        $time = Time::now();
        self::assertEquals(date('G:i:s'), (string) $time);
    }

    public function testZero(): void
    {
        $time = Time::zero();
        self::assertEquals('0:00:00', (string) $time);
    }

    public function testSameValueAs(): void
    {
        $time1 = new Time(new Hour(20), new Minute(10), new Second(34));
        $time2 = new Time(new Hour(20), new Minute(10), new Second(34));
        $time3 = new Time(new Hour(20), new Minute(1), new Second(10));

        self::assertTrue($time1->sameValueAs($time2));
        self::assertTrue($time2->sameValueAs($time1));
        self::assertFalse($time1->sameValueAs($time3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($time1->sameValueAs($mock));
    }

    public function testGetHour(): void
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $hour = new Hour(20);

        self::assertTrue($hour->sameValueAs($time->getHour()));
    }

    public function testGetMinute(): void
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $minute = new Minute(10);

        self::assertTrue($minute->sameValueAs($time->getMinute()));
    }

    public function testGetSecond(): void
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $day = new Second(34);

        self::assertTrue($day->sameValueAs($time->getSecond()));
    }

    public function testToNativeDateTime(): void
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        $nativeTime = DateTime::createFromFormat('H:i:s', '20:10:34');

        self::assertEquals($nativeTime, $time->toNativeDateTime());
    }

    public function testToString(): void
    {
        $time = new Time(new Hour(20), new Minute(10), new Second(34));
        self::assertEquals('20:10:34', $time->__toString());
    }
}
