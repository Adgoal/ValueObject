<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\DateTime\Exception\InvalidDateException;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use DateTime;
use Exception;

/**
 * Class Date.
 */
class Date implements ValueObjectInterface
{
    /**
     * Year ValueObject.
     *
     * @var Year
     */
    protected $year;

    /**
     * Month ValueObject.
     *
     * @var Month
     */
    protected $month;

    /**
     * MonthDay ValueObject.
     *
     * @var MonthDay
     */
    protected $day;

    /**
     * Returns a new Date from native year, month and day values.
     *
     * @return static
     *
     * @throws InvalidDateException
     * @throws Exception
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (!isset($args[1])) {
            $dateTime = new DateTime('@'.strtotime($args[0]));

            return self::fromNativeDateTime($dateTime);
        }

        $year = new Year($args[0]);
        $month = Month::fromNative($args[1]);
        $day = new MonthDay($args[2]);
        /** @psalm-suppress ArgumentTypeCoercion */
        return new static($year, $month, $day);
    }

    /**
     * Return native value.
     *
     * @return DateTime
     *
     * @throws Exception
     */
    public function toNative()
    {
        return $this->toNativeDateTime();
    }

    /**
     * Returns a new Date from a native PHP DateTime.
     *
     * @param DateTime $date
     *
     * @return static
     *
     * @throws InvalidDateException
     */
    public static function fromNativeDateTime(DateTime $date): self
    {
        $year = (int) $date->format('Y');
        $month = Month::fromNativeDateTime($date);
        $day = (int) $date->format('d');

        return new static(new Year($year), $month, new MonthDay($day));
    }

    /**
     * Returns current Date.
     *
     * @return static
     *
     * @throws InvalidDateException
     * @throws Exception
     * @throws Exception
     * @throws Exception
     */
    public static function now(): self
    {
        return new static(Year::now(), Month::now(), MonthDay::now());
    }

    /**
     * Create a new Date.
     *
     * @param Year     $year
     * @param Month    $month
     * @param MonthDay $day
     *
     * @throws InvalidDateException
     */
    public function __construct(Year $year, Month $month, MonthDay $day)
    {
        DateTime::createFromFormat('Y-F-j', sprintf('%d-%s-%d', $year->toNative(), $month->__toString(), $day->toNative()));
        $nativeDateErrors = DateTime::getLastErrors();

        if ($nativeDateErrors['warning_count'] > 0 || $nativeDateErrors['error_count'] > 0) {
            throw new InvalidDateException($year->toNative(), $month->toNative(), $day->toNative());
        }

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * Tells whether two Date are equal by comparing their values.
     *
     * @param ValueObjectInterface $date
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $date): bool
    {
        if (!$date instanceof static) {
            return false;
        }

        return $this->getYear()->sameValueAs($date->getYear()) &&
               $this->getMonth()->sameValueAs($date->getMonth()) &&
               $this->getDay()->sameValueAs($date->getDay());
    }

    /**
     * Return Year ValueObject.
     *
     * @return Year
     */
    public function getYear(): Year
    {
        return clone $this->year;
    }

    /**
     * Return Month ValueObject.
     *
     * @return Month
     */
    public function getMonth(): Month
    {
        return $this->month;
    }

    /**
     * Return MonthDay ValueObject.
     *
     * @return MonthDay
     */
    public function getDay(): MonthDay
    {
        return clone $this->day;
    }

    /**
     * Returns a native PHP DateTime version of the current Date.
     *
     * @return DateTime
     *
     * @throws Exception
     */
    public function toNativeDateTime(): DateTime
    {
        $year = $this->getYear()->toNative();
        $month = $this->getMonth()->getNumericValue();
        $day = $this->getDay()->toNative();

        $date = new DateTime();
        $date->setDate($year, $month, $day);
        $date->setTime(0, 0);

        return $date;
    }

    /**
     * Returns date as string in format Y-n-j.
     *
     * @return string
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        return $this->toNativeDateTime()->format('Y-n-j') ?: '';
    }
}
