<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Country\CountryAlpha2;
use AdgoalCommon\ValueObject\Geography\Country\CountryCodeAlpha2;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class CountryTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeCountry = CountryAlpha2::fromNative('IT');
        $constructedCountry = new CountryAlpha2(CountryCodeAlpha2::IT());

        self::assertTrue($constructedCountry->sameValueAs($fromNativeCountry));
    }

    public function testSameValueAs(): void
    {
        $country1 = new CountryAlpha2(CountryCodeAlpha2::IT());
        $country2 = new CountryAlpha2(CountryCodeAlpha2::IT());
        $country3 = new CountryAlpha2(CountryCodeAlpha2::US());

        self::assertTrue($country1->sameValueAs($country2));
        self::assertTrue($country2->sameValueAs($country1));
        self::assertFalse($country1->sameValueAs($country3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($country1->sameValueAs($mock));
    }

    public function testGetCode(): void
    {
        $italy = new CountryAlpha2(CountryCodeAlpha2::IT());
        self::assertTrue($italy->getCode()->sameValueAs(CountryCodeAlpha2::IT()));
    }

    public function testGetName(): void
    {
        $italy = new CountryAlpha2(CountryCodeAlpha2::IT());
        $name = new StringLiteral('Italy');
        self::assertTrue($italy->getName()->sameValueAs($name));
    }

    public function testToString(): void
    {
        $italy = new CountryAlpha2(CountryCodeAlpha2::IT());
        self::assertSame('Italy', $italy->__toString());
    }
}
