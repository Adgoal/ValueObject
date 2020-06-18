<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\Number\Integer;
use DateTime;
use Exception;

/**
 * Class Year.
BooleanDateTime
 */
class Year extends Integer
{
    /**
     * Returns the current year.
     *
     * @return static
     *
     * @throws Exception
     */
    public static function now(): self
    {
        $now = new DateTime('now');
        $year = (int) $now->format('Y');

        return new static($year);
    }
}
