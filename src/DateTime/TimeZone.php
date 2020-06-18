<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime;

use AdgoalCommon\ValueObject\DateTime\Exception\InvalidTimeZoneException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use DateTimeZone;

class TimeZone implements ValueObjectInterface
{
    /**
     * Hour ValueObject.
     *
     * @var StringLiteral
     */
    protected $name;

    /**
     * Returns a new Time object from native timezone name.
     *
     * @return static
     *
     * @throws InvalidTimeZoneException
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        $name = new StringLiteral($args[0]);

        return new static($name);
    }

    /**
     * Returns a new Time from a native PHP DateTime.
     *
     * @param DateTimeZone $timezone
     *
     * @return self
     *
     * @throws InvalidTimeZoneException
     */
    public static function fromNativeDateTimeZone(DateTimeZone $timezone): self
    {
        return static::fromNative($timezone->getName());
    }

    /**
     * Returns default TimeZone.
     *
     * @return static
     *
     * @throws InvalidTimeZoneException
     */
    public static function fromDefault(): self
    {
        return new static(new StringLiteral(date_default_timezone_get()));
    }

    /**
     * Returns a new TimeZone object.
     *
     * @param StringLiteral $name
     *
     * @throws InvalidTimeZoneException
     */
    public function __construct(StringLiteral $name)
    {
        if (!in_array($name->toNative(), timezone_identifiers_list(), true)) {
            throw new InvalidTimeZoneException($name);
        }

        $this->name = $name;
    }

    /**
     * Return native value.
     *
     * @return DateTimeZone
     */
    public function toNative()
    {
        return $this->toNativeDateTimeZone();
    }

    /**
     * Returns a native PHP DateTimeZone version of the current TimeZone.
     *
     * @return DateTimeZone
     */
    public function toNativeDateTimeZone(): DateTimeZone
    {
        return new DateTimeZone($this->getName()->toNative());
    }

    /**
     * Tells whether two DateTimeZone are equal by comparing their names.
     *
     * @param ValueObjectInterface $timezone
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $timezone): bool
    {
        if (!$timezone instanceof static) {
            return false;
        }

        return $this->getName()->sameValueAs($timezone->getName());
    }

    /**
     * Returns timezone name.
     *
     * @return StringLiteral
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns timezone name as string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName()->__toString();
    }
}
