<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\ValueObjectInterface;
use DateTime;
use Exception;

/**
 * Class Time.
 */
class Time implements ValueObjectInterface
{
    /**
     * Hour ValueObject.
     *
     * @var Hour
     */
    protected $hour;

    /**
     * Minute ValueObject.
     *
     * @var Minute
     */
    protected $minute;

    /**
     * Second ValueObject.
     *
     * @var Second
     */
    protected $second;

    /**
     * Returns a nee Time object from native int hour, minute and second.
     *
     * @return static
     *
     * @throws Exception
     * @throws Exception
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (!isset($args[1])) {
            $dateTime = new DateTime('@'.strtotime($args[0]));

            return self::fromNativeDateTime($dateTime);
        }

        $hour = new Hour($args[0]);
        $minute = new Minute($args[1]);
        $second = new Second($args[2]);

        return new static($hour, $minute, $second);
    }

    /**
     * Returns a new Time from a native PHP DateTime.
     *
     * @param DateTime $time
     *
     * @return Time
     *
     * @throws Exception
     */
    public static function fromNativeDateTime(DateTime $time): self
    {
        $hour = (int) $time->format('G');
        $minute = (int) $time->format('i');
        $second = (int) $time->format('s');

        return static::fromNative($hour, $minute, $second);
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
     * Returns current Time ValueObject.
     *
     * @return static
     *
     * @throws Exception
     */
    public static function now(): self
    {
        return new static(Hour::now(), Minute::now(), Second::now());
    }

    /**
     * Return zero Time ValueObject.
     *
     * @return static
     */
    public static function zero(): self
    {
        return new static(new Hour(0), new Minute(0), new Second(0));
    }

    /**
     * Returns a new Time objects.
     *
     * @param Hour   $hour
     * @param Minute $minute
     * @param Second $second
     */
    public function __construct(Hour $hour, Minute $minute, Second $second)
    {
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    /**
     * Tells whether two Time are equal by comparing their values.
     *
     * @param ValueObjectInterface $time
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $time): bool
    {
        if (!$time instanceof static) {
            return false;
        }

        return $this->getHour()->sameValueAs($time->getHour()) && $this->getMinute()->sameValueAs($time->getMinute()) && $this->getSecond()->sameValueAs($time->getSecond());
    }

    /**
     * Get Hour ValueObject.
     *
     * @return Hour
     */
    public function getHour(): Hour
    {
        return $this->hour;
    }

    /**
     * Get Minute ValueObject.
     *
     * @return Minute
     */
    public function getMinute(): Minute
    {
        return $this->minute;
    }

    /**
     * Get Second ValueObject.
     *
     * @return Second
     */
    public function getSecond(): Second
    {
        return $this->second;
    }

    /**
     * Returns a native PHP DateTime version of the current Time.
     * Date is set to current.
     *
     * @return DateTime
     *
     * @throws Exception
     */
    public function toNativeDateTime(): DateTime
    {
        $hour = $this->getHour()->toNative();
        $minute = $this->getMinute()->toNative();
        $second = $this->getSecond()->toNative();

        $time = new DateTime('now');
        $time->setTime($hour, $minute, $second);

        return $time;
    }

    /**
     * Returns time as string in format G:i:s.
     *
     * @return string
     *
     * @throws Exception
     */
    public function __toString(): string
    {
        return $this->toNativeDateTime()->format('G:i:s') ?: '';
    }
}
