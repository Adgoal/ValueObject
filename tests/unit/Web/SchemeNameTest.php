<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\SchemeName;

class SchemeNameTest extends TestCase
{
    public function testValidSchemeName(): void
    {
        $scheme = new SchemeName('git+ssh');
        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\SchemeName', $scheme);
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidSchemeName(): void
    {
        new SchemeName('ht*tp');
    }
}
