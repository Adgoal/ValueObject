<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Climate;

use AdgoalCommon\ValueObject\Climate\RelativeHumidity;
use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class RelativeHumidityTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeRelHum = RelativeHumidity::fromNative(70);
        $constructedRelHum = new RelativeHumidity(70);

        self::assertTrue($fromNativeRelHum->sameValueAs($constructedRelHum));
    }

    public function testInvalidRelativeHumidity(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new RelativeHumidity(128);
    }
}
