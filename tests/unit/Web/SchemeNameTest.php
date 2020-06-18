<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\SchemeName;

class SchemeNameTest extends TestCase
{
    public function testValidSchemeName(): void
    {
        $scheme = new SchemeName('git+ssh');
        $this->assertInstanceOf(SchemeName::class, $scheme);
    }

    public function testInvalidSchemeName(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);

        new SchemeName('ht*tp');
    }
}
