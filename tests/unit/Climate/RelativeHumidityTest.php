<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Climate;

use AdgoalCommon\ValueObject\Climate\RelativeHumidity;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class RelativeHumidityTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeRelHum = RelativeHumidity::fromNative(70);
        $constructedRelHum = new RelativeHumidity(70);

        $this->assertTrue($fromNativeRelHum->sameValueAs($constructedRelHum));
    }

    /**
     * @expectedException \AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException
     */
    public function testInvalidRelativeHumidity(): void
    {
        new RelativeHumidity(128);
    }
}
