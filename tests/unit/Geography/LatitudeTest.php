<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Latitude;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class LatitudeTest extends TestCase
{
    public function testValidLatitude(): void
    {
        new Latitude(40.829137);
    }

    public function testNormalization(): void
    {
        $latitude = new Latitude(91);
        $this->assertEquals(90, $latitude->toNative());
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidLatitude(): void
    {
        new Latitude('invalid');
    }
}
