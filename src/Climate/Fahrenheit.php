<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Climate;

/**
 * Class Fahrenheit.
 */
class Fahrenheit extends Temperature
{
    /**
     * Convert to Celsius ValueObject type.
     *
     * @return Celsius
     */
    public function toCelsius(): Celsius
    {
        return new Celsius(($this->value - 32) / 1.8);
    }

    /**
     * Convert to Kelvin ValueObject type.
     *
     * @return Kelvin
     */
    public function toKelvin(): Kelvin
    {
        return new Kelvin($this->toCelsius()->toNative() + 273.15);
    }

    /**
     * Convert to Fahrenheit ValueObject type.
     *
     * @return static
     */
    public function toFahrenheit(): self
    {
        return new static($this->value);
    }
}
