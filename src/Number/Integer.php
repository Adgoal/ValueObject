<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Number;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Exception\ValueObjectException;
use AdgoalCommon\ValueObject\ValueObjectInterface;

/**
 * Class Integer.
 */
class Integer extends Real
{
    /**
     * Returns a Integer object given a PHP native int as parameter.
     *
     * @param int $value
     */
    public function __construct($value)
    {
        $value = filter_var($value, FILTER_VALIDATE_INT);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int'], static::class);
        }

        parent::__construct($value);
    }

    /**
     * Tells whether two Integer are equal by comparing their values.
     *
     * @param ValueObjectInterface $integer
     *
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $integer): bool
    {
        if (!$integer instanceof static) {
            return false;
        }

        return $this->toNative() === $integer->toNative();
    }

    /**
     * Returns the value of the integer number.
     *
     * @return int
     */
    public function toNative()
    {
        $value = parent::toNative();

        return (int) $value;
    }

    /**
     * Returns a Real with the value of the Integer.
     *
     * @return Real
     */
    public function toReal(): Real
    {
        $value = $this->toNative();

        return new Real($value);
    }

    /**
     * Increment value.
     *
     * @return $this
     */
    public function inc(): self
    {
        ++$this->value;

        return $this;
    }

    /**
     * Decrement value.
     *
     * @return $this
     */
    public function decr(): self
    {
        --$this->value;

        return $this;
    }
}
