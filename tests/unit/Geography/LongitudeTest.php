<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Longitude;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class LongitudeTest extends TestCase
{
    public function testValidLongitude(): void
    {
        new Longitude(16.555838);
    }

    public function testNormalization(): void
    {
        $longitude = new Longitude(181);
        $this->assertEquals(-179, $longitude->toNative());
    }

    public function testInvalidLongitude(): void
    {
        $this->expectException(\TypeError::class);

        new Longitude('invalid');
    }
}
