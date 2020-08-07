<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Longitude;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use TypeError;

class LongitudeTest extends TestCase
{
    public function testValidLongitude(): void
    {
        new Longitude(16.555838);
        self::assertTrue(true);
    }

    public function testNormalization(): void
    {
        $longitude = new Longitude(181);
        self::assertEquals(-179, $longitude->toNative());
    }

    public function testInvalidLongitude(): void
    {
        try {
            new Longitude('invalid');
        } catch (TypeError $error) {
            self::assertTrue(true);
        }
    }
}
