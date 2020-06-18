<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Climate;

/**
 * Class Celsius.
 */
class Celsius extends Temperature
{
    /**
     * Convert to Celsius ValueObject type.
     *
     * @return static
     */
    public function toCelsius(): self
    {
        return new static($this->value);
    }

    /**
     * Convert to Kelvin ValueObject type.
     *
     * @return Kelvin
     */
    public function toKelvin(): Kelvin
    {
        return new Kelvin($this->value + 273.15);
    }

    /**
     * Convert to Fahrenheit ValueObject type.
     *
     * @return Fahrenheit
     */
    public function toFahrenheit(): Fahrenheit
    {
        return new Fahrenheit($this->value * 1.8 + 32);
    }
}
