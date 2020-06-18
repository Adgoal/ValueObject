<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\Enum\Enum;
use DateTime;
use Exception;

/**
 * Class Month.
 */
class Month extends Enum
{
    public const JANUARY = 'January';
    public const FEBRUARY = 'February';
    public const MARCH = 'March';
    public const APRIL = 'April';
    public const MAY = 'May';
    public const JUNE = 'June';
    public const JULY = 'July';
    public const AUGUST = 'August';
    public const SEPTEMBER = 'September';
    public const OCTOBER = 'October';
    public const NOVEMBER = 'November';
    public const DECEMBER = 'December';

    /**
     * Get current Month.
     *
     * @return Month
     *
     * @throws Exception
     */
    public static function now(): self
    {
        $now = new DateTime('now');

        return static::fromNativeDateTime($now);
    }

    /**
     * Returns Month from a native PHP DateTime.
     *
     * @param DateTime $date
     *
     * @return Month
     */
    public static function fromNativeDateTime(DateTime $date): self
    {
        $month = strtoupper($date->format('F'));

        return static::byName($month);
    }

    /**
     * Returns a numeric representation of the Month.
     * 1 for January to 12 for December.
     *
     * @return int
     */
    public function getNumericValue(): int
    {
        return $this->getOrdinal() + 1;
    }
}
