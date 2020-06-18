<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Exception\InvalidTimeZoneException;
use AdgoalCommon\ValueObject\DateTime\TimeZone;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class TimeZoneTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeTimeZone = TimeZone::fromNative('Europe/Madrid');
        $constructedTimeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $this->assertTrue($fromNativeTimeZone->sameValueAs($constructedTimeZone));
    }

    public function testFromNativeDateTimeZone(): void
    {
        $nativeTimeZone = new \DateTimeZone('Europe/Madrid');
        $timeZoneFromNative = TimeZone::fromNativeDateTimeZone($nativeTimeZone);

        $constructedTimeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $this->assertTrue($timeZoneFromNative->sameValueAs($constructedTimeZone));
    }

    public function testDefaultTz(): void
    {
        $timeZone = TimeZone::fromDefault();
        $this->assertEquals(date_default_timezone_get(), (string) $timeZone);
    }

    public function testSameValueAs(): void
    {
        $timeZone1 = new TimeZone(new StringLiteral('Europe/Madrid'));
        $timeZone2 = new TimeZone(new StringLiteral('Europe/Madrid'));
        $timeZone3 = new TimeZone(new StringLiteral('Europe/Berlin'));

        $this->assertTrue($timeZone1->sameValueAs($timeZone2));
        $this->assertTrue($timeZone2->sameValueAs($timeZone1));
        $this->assertFalse($timeZone1->sameValueAs($timeZone3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($timeZone1->sameValueAs($mock));
    }

    public function testGetName(): void
    {
        $name = new StringLiteral('Europe/Madrid');
        $timeZone = new TimeZone($name);

        $this->assertTrue($name->sameValueAs($timeZone->getName()));
    }

    public function testToNativeDateTimeZone(): void
    {
        $nativeTimeZone = new \DateTimeZone('Europe/Madrid');
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $this->assertEquals($nativeTimeZone, $timeZone->toNativeDateTimeZone());
    }

    public function testToString(): void
    {
        $timeZone = new TimeZone(new StringLiteral('Europe/Madrid'));

        $this->assertEquals('Europe/Madrid', $timeZone->__toString());
    }

    public function testExceptionOnInvalidTimeZoneName(): void
    {
        $this->expectException(InvalidTimeZoneException::class);

        new TimeZone(new StringLiteral('Mars/Phobos'));
    }
}
