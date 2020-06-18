<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Geography;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Number\Real;
use League\Geotools\Coordinate\Coordinate as BaseCoordinate;

/**
 * Class Longitude.
 */
class Longitude extends Real
{
    /**
     * Returns a new Longitude object.
     *
     * @param float $value
     *
     * @throws InvalidNativeArgumentException
     */
    public function __construct(float $value)
    {
        // normalization process through Coordinate object
        $coordinate = new BaseCoordinate([0, $value]);
        $longitude = $coordinate->getLongitude();

        parent::__construct($longitude);
    }
}
