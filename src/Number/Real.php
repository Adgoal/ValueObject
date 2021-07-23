<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Number;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Number\Integer as IntegerValueObject;
use AdgoalCommon\ValueObject\ValueObjectInterface;

/**
 * Class Real.
 */
class Real implements ValueObjectInterface, NumberInterface
{
    /**
     * @var float|int
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
     * Returns a Real object given a PHP native float as parameter.
     *
     * @param float|int $value
     */
    public function __construct(float $value)
    {
        $value = filter_var($value, FILTER_VALIDATE_FLOAT);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['float'], static::class);
        }

        $this->value = $value;
    }

    /**
     * Returns the native value of the real number.
     *
     * @return float|int
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * Tells whether two Real are equal by comparing their values.
     *
     * @param ValueObjectInterface $real
     *
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $real): bool
    {
        if (!$real instanceof static) {
            return false;
        }

        return $this->toNative() === $real->toNative();
    }

    /**
     * Returns the integer part of the Real number as a Integer.
     *
     * @param RoundingMode|null $roundingMode Rounding mode of the conversion. Defaults to RoundingMode::HALF_UP.
     *
     * @return IntegerValueObject
     */
    public function toInteger(?RoundingMode $roundingMode = null): IntegerValueObject
    {
        if (null === $roundingMode) {
            $roundingMode = RoundingMode::HALF_UP();
        }

        $value = $this->toNative();
        $integerValue = round($value, 0, $roundingMode->toNative());

        return new Integer((int) $integerValue);
    }

    /**
     * Returns the absolute integer part of the Real number as a Natural.
     *
     * @param RoundingMode|null $roundingMode Rounding mode of the conversion. Defaults to RoundingMode::HALF_UP.
     *
     * @return Natural
     */
    public function toNatural(?RoundingMode $roundingMode = null): Natural
    {
        $integerValue = $this->toInteger($roundingMode)->toNative();
        $naturalValue = abs($integerValue);

        return new Natural($naturalValue);
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
