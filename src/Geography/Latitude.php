<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Geography;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Number\Real;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;

/**
 * Class Latitude.
 */
class Latitude extends Real
{
    /**
     * Returns a new Latitude object.
     *
     * @param float $value
     *
     * @throws InvalidNativeArgumentException
     */
    public function __construct(float $value)
    {
        // normalization process through Coordinate object
        $coordinate = new BaseCoordinate([$value, 0]);
        $latitude = $coordinate->getLatitude();

        parent::__construct($latitude);
    }
}
