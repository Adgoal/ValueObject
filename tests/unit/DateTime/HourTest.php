<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Hour;
use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class HourTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeHour = Hour::fromNative(21);
        $constructedHour = new Hour(21);

        self::assertTrue($fromNativeHour->sameValueAs($constructedHour));
    }

    public function testNow(): void
    {
        $hour = Hour::now();
        self::assertEquals(date('G'), $hour->toNative());
    }

    public function testInvalidHour(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new Hour(24);
    }
}
