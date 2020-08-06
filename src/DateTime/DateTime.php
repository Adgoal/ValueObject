<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\DateTime\Exception\InvalidDateException;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use DateTime as BaseDateTime;
use Exception;

class DateTime implements ValueObjectInterface
{
    /**
     * Date ValueObject.
     *
     * @var Date
     */
    protected $date;

    /**
     * Date ValueObject.
     *
     * @var Time
     */
    protected $time;

    /**
     * Returns a new DateTime object from native values.
     *
     * @return static
     *
     * @throws InvalidDateException
     * @throws Exception
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (!isset($args['1'])) {
            if (is_object($args['1']) &&  $args['1'] instanceof \DateTime) {
                return self::fromNativeDateTime($dateTime);
            }
            $dateTime = new BaseDateTime('@'.strtotime($args[0]));

            return self::fromNativeDateTime($dateTime);
        }

        $date = Date::fromNative($args[0], $args[1], $args[2]);
        $time = Time::fromNative($args[3], $args[4], $args[5]);

        return new static($date, $time);
    }

    /**
     * Return native value.
     *
     * @return BaseDateTime
     *
     * @throws Exception
     */
    public function toNative()
    {
        return $this->toNativeDateTime();
    }

    /**
     * Returns a new DateTime from a native PHP DateTime.
     *
     * @param BaseDateTime $dateTime
     *
     * @return static
     *
     * @throws InvalidDateException
     */
    public static function fromNativeDateTime(BaseDateTime $dateTime): self
    {
        $date = Date::fromNativeDateTime($dateTime);
        $time = Time::fromNativeDateTime($dateTime);

        return new static($date, $time);
    }

    /**
     * Returns current DateTime.
     *
     * @return static
     *
     * @throws InvalidDateException
     * @throws Exception
     */
    public static function now(): self
    {
        return new static(Date::now(), Time::now());
    }

    /**
     * Returns a new DateTime object.
     *
     * @param Date $date
     * @param Time $time
     */
    public function __construct(Date $date, ?Time $time = null)
    {
        $this->date = $date;

        if (null === $time) {
            $time = Time::zero();
        }

        $this->time = $time;
    }

    /**
     * Tells whether two DateTime are equal by comparing their values.
     *
     * @param ValueObjectInterface $dateTime
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $dateTime): bool
    {
        if (!$dateTime instanceof static) {
            return false;
        }

        return $this->getDate()->sameValueAs($dateTime->getDate()) && $this->getTime()->sameValueAs($dateTime->getTime());
    }

    /**
     * Returns date from current DateTime.
     *
     * @return Date
     */
    public function getDate(): Date
    {
        return clone $this->date;
    }

    /**
     * Returns time from current DateTime.
     *
     * @return Time
     */
    public function getTime(): Time
    {
        return clone $this->time;
    }

    /**
     * Returns a native PHP DateTime version of the current DateTime.
     *
     * @return BaseDateTime
     *
     * @throws Exception
     */
    public function toNativeDateTime(): BaseDateTime
    {
        $year = $this->getDate()->getYear()->toNative();
        $month = $this->getDate()->getMonth()->getNumericValue();
        $day = $this->getDate()->getDay()->toNative();
        $hour = $this->getTime()->getHour()->toNative();
        $minute = $this->getTime()->getMinute()->toNative();
        $second = $this->getTime()->getSecond()->toNative();

        $dateTime = new BaseDateTime();
        $dateTime->setDate($year, $month, $day);
        $dateTime->setTime($hour, $minute, $second);

        return $dateTime;
    }

    /**
     * Returns DateTime as string in format "Y-n-j G:i:s".
     *
     * @return string
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        return sprintf('%s %s', $this->getDate()->__toString(), $this->getTime()->__toString());
    }
}
