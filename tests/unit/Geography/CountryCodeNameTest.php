<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Country\CountryCodeAlpha2;
use AdgoalCommon\ValueObject\Geography\Country\CountryCodeNameAlpha2;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class CountryCodeNameTest extends TestCase
{
    public function testGetName(): void
    {
        $code = CountryCodeAlpha2::IT();
        $name = CountryCodeNameAlpha2::getName($code);
        $expectedString = new StringLiteral('Italy');

        self::assertTrue($name->sameValueAs($expectedString));
    }
}
