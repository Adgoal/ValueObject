<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Coordinate;
use AdgoalCommon\ValueObject\Geography\Ellipsoid;
use AdgoalCommon\ValueObject\Geography\Latitude;
use AdgoalCommon\ValueObject\Geography\Longitude;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use BadMethodCallException;

class CoordinateTest extends TestCase
{
    /** @var Coordinate */
    protected $coordinate;

    protected function setUp(): void
    {
        $this->coordinate = new Coordinate(
            new Latitude(40.829137),
            new Longitude(16.555838)
        );
    }

    public function testNullConstructorEllipsoid(): void
    {
        self::assertTrue($this->coordinate->getEllipsoid()->sameValueAs(Ellipsoid::WGS84()));
    }

    public function testFromNative(): void
    {
        $fromNativeCoordinate = Coordinate::fromNative(40.829137, 16.555838, 'WGS84');
        self::assertTrue($this->coordinate->sameValueAs($fromNativeCoordinate));
    }

    public function testInvalidFromNative(): void
    {
        $this->expectException(BadMethodCallException::class);
        Coordinate::fromNative(40.829137);
    }

    public function testSameValueAs(): void
    {
        $coordinate2 = new Coordinate(
            new Latitude(40.829137),
            new Longitude(16.555838)
        );
        $coordinate3 = new Coordinate(
            new Latitude(40.829137),
            new Longitude(16.555838),
            Ellipsoid::WGS60()
        );

        self::assertTrue($this->coordinate->sameValueAs($coordinate2));
        self::assertTrue($coordinate2->sameValueAs($this->coordinate));
        self::assertFalse($this->coordinate->sameValueAs($coordinate3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($this->coordinate->sameValueAs($mock));
    }

    public function getLatitude(): void
    {
        $latitude = new Latitude(40.829137);
        self::assertTrue($this->coordinate->getLatitude()->sameValueAs($latitude));
    }

    public function getLongitude(): void
    {
        $longitude = new Longitude(16.555838);
        self::assertTrue($this->coordinate->getLongitude()->sameValueAs($longitude));
    }

    public function getEllipsoid(): void
    {
        $ellipsoid = Ellipsoid::WGS84();
        self::assertTrue($this->coordinate->getEllipsoid()->sameValueAs($ellipsoid));
    }

    public function testToDegreesMinutesSeconds(): void
    {
        $dms = new StringLiteral('40°49′45″N, 16°33′21″E');
        self::assertTrue($this->coordinate->toDegreesMinutesSeconds()->sameValueAs($dms));
    }

    public function testToDecimalMinutes(): void
    {
        $dm = new StringLiteral('40 49.74822N, 16 33.35028E');
        self::assertTrue($this->coordinate->toDecimalMinutes()->sameValueAs($dm));
    }

    public function testToUniversalTransverseMercator(): void
    {
        $utm = new StringLiteral('33T 631188 4520953');
        self::assertTrue($this->coordinate->toUniversalTransverseMercator()->sameValueAs($utm));
    }

    public function testDistanceFrom(): void
    {
        $newYork = new Coordinate(
            new Latitude(41.145556),
            new Longitude(-73.995)
        );

        $distance = $this->coordinate->distanceFrom($newYork);
        self::assertSame(7609068.4225575, $distance->toNative());
    }

    public function testToString(): void
    {
        self::assertSame('40.829137,16.555838', $this->coordinate->__toString());
    }
}
