<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Second;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class SecondTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeSecond = Second::fromNative(13);
        $constructedSecond = new Second(13);

        $this->assertTrue($fromNativeSecond->sameValueAs($constructedSecond));
    }

    public function testNow(): void
    {
        $second = Second::now();
        $this->assertEquals(intval(date('s')), $second->toNative());
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidSecond(): void
    {
        new Second(60);
    }
}
