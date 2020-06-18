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
     * @var float
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
     * @param float $value
     */
    public function __construct(float $value)
    {
        $value = filter_var($value, FILTER_VALIDATE_FLOAT);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['float']);
        }

        $this->value = $value;
    }

    /**
     * Returns the native value of the real number.
     *
     * @return float
     */
    public function toNative(): float
    {
        return $this->value;
    }

    /**
     * Tells whether two Real are equal by comparing their values.
     *
     * @param ValueObjectInterface $value
     * @param int                  $scale
     *
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $value, int $scale = 0): bool
    {
        if (!$value instanceof static) {
            return false;
        }

        if (extension_loaded('bcmath')) {
            return 0 === bccomp((string) $this->toNative(), (string) $value->toNative(), $scale);
        }

        if ($scale > 0) {
            $ratio = pow(10, $scale);
            $selfValue = (new self($this->toNative() * $ratio))->toInteger();
            $incomeValue = (new self($value->toNative() * $ratio))->toInteger();

            return $selfValue->toNative() === $incomeValue->toNative();
        }

        return (string) $this->toNative() === (string) $value->toNative();
    }

    /**
     * Returns the integer part of the Real number as a Integer.
     *
     * @param RoundingMode $roundingMode Rounding mode of the conversion. Defaults to RoundingMode::HALF_UP.
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
     * @param RoundingMode $roundingMode Rounding mode of the conversion. Defaults to RoundingMode::HALF_UP.
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
