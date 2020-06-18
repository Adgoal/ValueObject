<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Number;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\ValueObjectInterface;

/**
 * Class Integer.
 */
class Integer implements ValueObjectInterface, NumberInterface
{
    /**
     * @var int
     */
    protected $value;

    /**
     * Returns a Real object given a PHP native float as parameter.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a Integer object given a PHP native int as parameter.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $value = filter_var($value, FILTER_VALIDATE_INT);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int']);
        }

        $this->value = $value;
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
        return $this->value;
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

    /**
     * Returns the string representation of the real value.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->toNative();
    }
}
