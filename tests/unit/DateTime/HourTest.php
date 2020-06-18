<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Hour;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class HourTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeHour = Hour::fromNative(21);
        $constructedHour = new Hour(21);

        $this->assertTrue($fromNativeHour->sameValueAs($constructedHour));
    }

    public function testNow(): void
    {
        $hour = Hour::now();
        $this->assertEquals(date('G'), $hour->toNative());
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidHour(): void
    {
        new Hour(24);
    }
}
