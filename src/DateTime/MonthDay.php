<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Number\Natural;
use DateTime;
use Exception;

/**
 * Class MonthDay.
 */
class MonthDay extends Natural
{
    public const MIN_MONTH_DAY = 1;
    public const MAX_MONTH_DAY = 31;

    /**
     * Returns a new MonthDay.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN_MONTH_DAY, 'max_range' => self::MAX_MONTH_DAY],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int (>=0, <=31)'], static::class);
        }

        parent::__construct($value);
    }

    /**
     * Returns the current month day.
     *
     * @return static
     *
     * @throws Exception
     */
    public static function now(): self
    {
        $now = new DateTime('now');
        $monthDay = (int) $now->format('j');

        return new static($monthDay);
    }
}
