<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Latitude;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use TypeError;

class LatitudeTest extends TestCase
{
    public function testValidLatitude(): void
    {
        new Latitude(40.829137);
        self::assertTrue(true);
    }

    public function testNormalization(): void
    {
        $latitude = new Latitude(91);
        self::assertEquals(90, $latitude->toNative());
    }

    public function testInvalidLatitude(): void
    {
        try {
            new Latitude('invalid');
        } catch (TypeError $e) {
            self::assertTrue(true);
        }
    }
}
