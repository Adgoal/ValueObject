<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Climate;

use AdgoalCommon\ValueObject\Climate\Celsius;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class CelsiusTest extends TestCase
{
    /**
     * @return mixed[]
     */
    public function temperatureProvider(): array
    {
        return [[new Celsius(10)]];
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Celsius $temperature
     */
    public function testToCelsius(Celsius $temperature): void
    {
        $this->assertEquals(10, $temperature->toCelsius()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Celsius $temperature
     */
    public function testToKelvin(Celsius $temperature): void
    {
        $this->assertEquals(10 + 273.15, $temperature->toKelvin()->toNative());
    }

    /**
     * @dataProvider temperatureProvider
     *
     * @param Celsius $temperature
     */
    public function testToFahrenheit(Celsius $temperature): void
    {
        $this->assertEquals(10 * 1.8 + 32, $temperature->toFahrenheit()->toNative());
    }
}
