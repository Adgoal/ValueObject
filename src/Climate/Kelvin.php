<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Climate;

/**
 * Class Kelvin.
 */
class Kelvin extends Temperature
{
    /**
     * Convert to Celsius ValueObject type.
     *
     * @return Celsius
     */
    public function toCelsius(): Celsius
    {
        return new Celsius($this->value - 273.15);
    }

    /**
     * Convert to Kelvin ValueObject type.
     *
     * @return static
     */
    public function toKelvin(): self
    {
        return new static($this->value);
    }

    /**
     * Convert to Fahrenheit ValueObject type.
     *
     * @return Fahrenheit
     */
    public function toFahrenheit(): Fahrenheit
    {
        return new Fahrenheit($this->toCelsius()->toNative() * 1.8 + 32);
    }
}
