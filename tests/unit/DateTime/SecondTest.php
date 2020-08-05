<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Second;
use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class SecondTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeSecond = Second::fromNative(13);
        $constructedSecond = new Second(13);

        self::assertTrue($fromNativeSecond->sameValueAs($constructedSecond));
    }

    public function testNow(): void
    {
        $second = Second::now();
        self::assertEquals((int) date('s'), $second->toNative());
    }

    public function testInvalidSecond(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new Second(60);
    }
}
