<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Number;

use AdgoalCommon\ValueObject\Enum\Enum;

/**
 * Class RoundingMode.
 */
class RoundingMode extends Enum
{
    public const HALF_UP = PHP_ROUND_HALF_UP;
    public const HALF_DOWN = PHP_ROUND_HALF_DOWN;
    public const HALF_EVEN = PHP_ROUND_HALF_EVEN;
    public const HALF_ODD = PHP_ROUND_HALF_ODD;
}
