<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Climate;

use AdgoalCommon\ValueObject\Climate\Fahrenheit;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class FahrenheitTest extends TestCase
{
    /**
     * @return mixed[]
     */
    public function temperatureProvider(): array
    {
        return [[new Fahrenheit(10)]];
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Fahrenheit $temperature
     */
    public function testToCelsius(Fahrenheit $temperature): void
    {
        $this->assertEquals((10 - 32) / 1.8, $temperature->toCelsius()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Fahrenheit $temperature
     */
    public function testToKelvin(Fahrenheit $temperature): void
    {
        $this->assertEquals($temperature->toCelsius()->toNative() + 273.15, $temperature->toKelvin()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Fahrenheit $temperature
     */
    public function testToFahrenheit(Fahrenheit $temperature): void
    {
        $this->assertEquals(10, $temperature->toFahrenheit()->toNative());
    }
}
