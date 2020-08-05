<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\DateTime\Exception\InvalidDateException;
use AdgoalCommon\ValueObject\DateTime\Exception\InvalidTimeZoneException;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use DateTime as BaseDateTime;
use Exception;

/**
 * Class DateTimeWithTimeZone.
 */
class DateTimeWithTimeZone implements ValueObjectInterface
{
    /**
     * DateTime ValueObject.
     *
     * @var DateTime
     */
    protected $dateTime;

    /**
     * TimeZone ValueObject.
     *
     * @var TimeZone|null
     */
    protected $timeZone;

    /**
     * Returns a new DateTime object from native values.
     *
     * @return static
     *
     * @throws InvalidDateException
     * @throws InvalidTimeZoneException
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (count($args) < 6) {
            throw new InvalidTimeZoneException('Invalid count of arguments.');
        }

        $datetime = DateTime::fromNative($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
        $timezone = TimeZone::fromNative($args[6]);

        return new static($datetime, $timezone);
    }

    /**
     * Returns a new DateTime from a native PHP DateTime.
     *
     * @param BaseDateTime $nativeDatetime
     *
     * @return static
     *
     * @throws InvalidDateException
     * @throws InvalidTimeZoneException
     */
    public static function fromNativeDateTime(BaseDateTime $nativeDatetime): self
    {
        $datetime = DateTime::fromNativeDateTime($nativeDatetime);
        $timezone = TimeZone::fromNativeDateTimeZone($nativeDatetime->getTimezone());

        return new static($datetime, $timezone);
    }

    /**
     * Returns a DateTimeWithTimeZone object using current DateTime and default TimeZone.
     *
     * @return static
     *
     * @throws InvalidDateException
     * @throws InvalidTimeZoneException
     */
    public static function now(): self
    {
        return new static(DateTime::now(), TimeZone::fromDefault());
    }

    /**
     * Returns a new DateTimeWithTimeZone object.
     *
     * @param DateTime $datetime
     * @param TimeZone $timezone
     */
    public function __construct(DateTime $datetime, ?TimeZone $timezone = null)
    {
        $this->dateTime = $datetime;
        $this->timeZone = $timezone;
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
     * Tells whether two DateTimeWithTimeZone are equal by comparing their values.
     *
     * @param ValueObjectInterface $dateTimeWithTimeZone
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     * @psalm-suppress PossiblyNullArgument
     */
    public function sameValueAs(ValueObjectInterface $dateTimeWithTimeZone): bool
    {
        if (!$dateTimeWithTimeZone instanceof static) {
            return false;
        }

        return
            $this->getDateTime()->sameValueAs($dateTimeWithTimeZone->getDateTime()) &&
            (
                ($this->timeZone && $dateTimeWithTimeZone->getTimeZone() && $this->timeZone->sameValueAs($dateTimeWithTimeZone->getTimeZone())) ||
                (null === $this->timeZone && null === $dateTimeWithTimeZone->getTimeZone())
            );
    }

    /**
     * Tells whether two DateTimeWithTimeZone represents the same timestamp.
     *
     * @param ValueObjectInterface $dateTimeWithTimeZone
     *
     * @return bool
     *
     * @throws Exception
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameTimestampAs(ValueObjectInterface $dateTimeWithTimeZone): bool
    {
        if (!$dateTimeWithTimeZone instanceof static) {
            return false;
        }

        return $this->toNativeDateTime()->getTimestamp() === $dateTimeWithTimeZone->toNativeDateTime()->getTimestamp();
    }

    /**
     * Returns datetime from current DateTimeWithTimeZone.
     *
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return clone $this->dateTime;
    }

    /**
     * Returns timezone from current DateTimeWithTimeZone.
     *
     * @return TimeZone|null
     */
    public function getTimeZone(): ?TimeZone
    {
        if (null === $this->timeZone) {
            return null;
        }

        return clone $this->timeZone;
    }

    /**
     * Returns a native PHP DateTime version of the current DateTimeWithTimeZone.
     *
     * @return BaseDateTime
     *
     * @throws Exception
     */
    public function toNativeDateTime(): BaseDateTime
    {
        $date = $this->getDateTime()->getDate();
        $time = $this->getDateTime()->getTime();
        $year = $date->getYear()->toNative();
        $month = $date->getMonth()->getNumericValue();
        $day = $date->getDay()->toNative();
        $hour = $time->getHour()->toNative();
        $minute = $time->getMinute()->toNative();
        $second = $time->getSecond()->toNative();

        $dateTime = new BaseDateTime();

        if ($this->timeZone) {
            $dateTime->setTimezone($this->timeZone->toNativeDateTimeZone());
        }
        $dateTime->setDate($year, $month, $day);
        $dateTime->setTime($hour, $minute, $second);

        return $dateTime;
    }

    /**
     * Returns DateTime as string in format "Y-n-j G:i:s e".
     *
     * @return string
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        $timezone = $this->timeZone ? $this->timeZone->__toString() : '';

        return sprintf('%s %s', $this->getDateTime()->__toString(), $timezone);
    }
}
