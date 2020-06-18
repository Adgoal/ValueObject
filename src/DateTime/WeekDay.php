<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\Enum\Enum;
use DateTime;
use Exception;

/**
 * Class WeekDay.
 */
class WeekDay extends Enum
{
    public const MONDAY = 'Monday';
    public const TUESDAY = 'Tuesday';
    public const WEDNESDAY = 'Wednesday';
    public const THURSDAY = 'Thursday';
    public const FRIDAY = 'Friday';
    public const SATURDAY = 'Saturday';
    public const SUNDAY = 'Sunday';

    /**
     * Returns the current week day.
     *
     * @return WeekDay
     *
     * @throws Exception
     */
    public static function now(): self
    {
        $now = new DateTime('now');

        return static::fromNativeDateTime($now);
    }

    /**
     * Returns a WeekDay from a PHP native DateTime.
     *
     * @param DateTime $date
     *
     * @return WeekDay
     */
    public static function fromNativeDateTime(DateTime $date): self
    {
        $weekDay = strtoupper($date->format('l'));

        return static::byName($weekDay);
    }

    /**
     * Returns a numeric representation of the WeekDay.
     * 1 for Monday to 7 for Sunday.
     *
     * @return int
     */
    public function getNumericValue(): int
    {
        return $this->getOrdinal() + 1;
    }
}
