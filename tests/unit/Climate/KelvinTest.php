<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Climate;

use AdgoalCommon\ValueObject\Climate\Kelvin;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class KelvinTest extends TestCase
{
    /**
     * @return mixed[]
     */
    public function temperatureProvider(): array
    {
        return [[new Kelvin(10)]];
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Kelvin $temperature
     */
    public function testToCelsius(Kelvin $temperature): void
    {
        $this->assertEquals(10 - 273.15, $temperature->toCelsius()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Kelvin $temperature
     */
    public function testToKelvin(Kelvin $temperature): void
    {
        $this->assertEquals(10, $temperature->toKelvin()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Kelvin $temperature
     */
    public function testToFahrenheit(Kelvin $temperature): void
    {
        $this->assertEquals($temperature->toCelsius()->toNative() * 1.8 + 32, $temperature->toFahrenheit()->toNative());
    }
}
