<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Geography;

use AdgoalCommon\ValueObject\Number\Real;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use BadMethodCallException;
use League\Geotools\Convert\Convert;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;
use League\Geotools\Coordinate\Ellipsoid as BaseEllipsoid;
use League\Geotools\Distance\Distance;

/**
 * Class Coordinate.
 */
class Coordinate implements ValueObjectInterface
{
    /**
     * Latitude ValueObject.
     *
     * @var Latitude
     */
    protected $latitude;

    /**
     * Longitude ValueObject.
     *
     * @var Longitude
     */
    protected $longitude;

    /**
     * Ellipsoid ValueObject.
     *
     * @var Ellipsoid
     */
    protected $ellipsoid;

    /**
     * Returns a new Coordinate object from native PHP arguments.
     *
     * @return self
     *
     * @throws BadMethodCallException
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (count($args) < 2 || count($args) > 3) {
            throw new BadMethodCallException('You must provide 2 to 3 arguments: 1) latitude, 2) longitude, 3) valid ellipsoid type (optional)');
        }

        $coordinate = new BaseCoordinate([$args[0], $args[1]]);
        $latitude = Latitude::fromNative($coordinate->getLatitude());
        $longitude = Longitude::fromNative($coordinate->getLongitude());
        $nativeEllipsoid = $args[2] ?? null;
        $ellipsoid = Ellipsoid::fromNative($nativeEllipsoid);

        /** @psalm-suppress ArgumentTypeCoercion */
        return new self($latitude, $longitude, $ellipsoid);
    }

    /**
     * Returns a new Coordinate object.
     *
     * @param Latitude  $latitude
     * @param Longitude $longitude
     * @param Ellipsoid $ellipsoid
     */
    public function __construct(Latitude $latitude, Longitude $longitude, ?Ellipsoid $ellipsoid = null)
    {
        if (null === $ellipsoid) {
            $ellipsoid = Ellipsoid::WGS84();
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->ellipsoid = $ellipsoid;
    }

    /**
     * Return native value.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->__toString();
    }

    /**
     * Tells whether tow Coordinate objects are equal.
     *
     * @param ValueObjectInterface $coordinate
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $coordinate): bool
    {
        if (!$coordinate instanceof static) {
            return false;
        }

        return $this->getLatitude()->sameValueAs($coordinate->getLatitude()) &&
               $this->getLongitude()->sameValueAs($coordinate->getLongitude()) &&
               $this->getEllipsoid()->sameValueAs($coordinate->getEllipsoid())
        ;
    }

    /**
     * Returns latitude.
     *
     * @return Latitude
     */
    public function getLatitude(): Latitude
    {
        return clone $this->latitude;
    }

    /**
     * Returns longitude.
     *
     * @return Longitude
     */
    public function getLongitude(): Longitude
    {
        return clone $this->longitude;
    }

    /**
     * Returns ellipsoid.
     *
     * @return Ellipsoid
     */
    public function getEllipsoid(): Ellipsoid
    {
        return $this->ellipsoid;
    }

    /**
     * Returns a degrees/minutes/seconds representation of the coordinate.
     *
     * @return StringLiteral
     */
    public function toDegreesMinutesSeconds(): StringLiteral
    {
        $coordinate = self::getBaseCoordinate($this);
        $convert = new Convert($coordinate);
        $dms = $convert->toDegreesMinutesSeconds();

        return new StringLiteral($dms);
    }

    /**
     * Returns a decimal minutes representation of the coordinate.
     *
     * @return StringLiteral
     */
    public function toDecimalMinutes(): StringLiteral
    {
        $coordinate = self::getBaseCoordinate($this);
        $convert = new Convert($coordinate);
        $dm = $convert->toDecimalMinutes();

        return new StringLiteral($dm);
    }

    /**
     * Returns a Universal Transverse Mercator projection representation of the coordinate in meters.
     *
     * @return StringLiteral
     */
    public function toUniversalTransverseMercator(): StringLiteral
    {
        $coordinate = self::getBaseCoordinate($this);
        $convert = new Convert($coordinate);
        $utm = $convert->toUniversalTransverseMercator();

        return new StringLiteral($utm);
    }

    /**
     * Calculates the distance between two Coordinate objects.
     *
     * @param Coordinate      $coordinate
     * @param DistanceUnit    $unit
     * @param DistanceFormula $formula
     *
     * @return Real
     */
    public function distanceFrom(self $coordinate, ?DistanceUnit $unit = null, ?DistanceFormula $formula = null): Real
    {
        if (null === $unit) {
            $unit = DistanceUnit::METER();
        }

        if (null === $formula) {
            $formula = DistanceFormula::FLAT();
        }

        $baseThis = self::getBaseCoordinate($this);
        $baseCoordinate = self::getBaseCoordinate($coordinate);
        $distance = new Distance();
        $distance
            ->setFrom($baseThis)
            ->setTo($baseCoordinate)
            ->in($unit->toNative());
        $value = $distance->{$formula->toNative()}();

        return new Real($value);
    }

    /**
     * Returns a native string version of the Coordinates object in format "$latitude,$longitude".
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%F,%F', $this->getLatitude()->toNative(), $this->getLongitude()->toNative());
    }

    /**
     * Returns the underlying Coordinate object.
     *
     * @param Coordinate $coordinate
     *
     * @return BaseCoordinate
     */
    protected static function getBaseCoordinate(self $coordinate): BaseCoordinate
    {
        $latitude = $coordinate->getLatitude()->toNative();
        $longitude = $coordinate->getLongitude()->toNative();
        $ellipsoid = BaseEllipsoid::createFromName($coordinate->getEllipsoid()->toNative());

        return new BaseCoordinate([$latitude, $longitude], $ellipsoid);
    }
}
