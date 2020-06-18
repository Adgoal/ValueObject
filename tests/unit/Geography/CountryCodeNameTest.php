<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\CountryCode;
use AdgoalCommon\ValueObject\Geography\CountryCodeName;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class CountryCodeNameTest extends TestCase
{
    public function testGetName(): void
    {
        $code = CountryCode::IT();
        $name = CountryCodeName::getName($code);
        $expectedString = new StringLiteral('Italy');

        $this->assertTrue($name->sameValueAs($expectedString));
    }
}
