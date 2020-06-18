<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Geography;

use AdgoalCommon\ValueObject\Enum\Enum;

/**
 * Class DistanceUnit.
 */
class DistanceUnit extends Enum
{
    public const FOOT = 'ft';
    public const METER = 'mt';
    public const KILOMETER = 'km';
    public const MILE = 'mi';
}
