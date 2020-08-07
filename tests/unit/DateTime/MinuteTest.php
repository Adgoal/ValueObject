<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Minute;
use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class MinuteTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeMinute = Minute::fromNative(11);
        $constructedMinute = new Minute(11);

        self::assertTrue($fromNativeMinute->sameValueAs($constructedMinute));
    }

    public function testNow(): void
    {
        $minute = Minute::now();
        self::assertEquals((int) date('i'), $minute->toNative());
    }

    public function testInvalidMinute(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new Minute(60);
    }
}
