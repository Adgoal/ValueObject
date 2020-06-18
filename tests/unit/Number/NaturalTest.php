<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Number;

use AdgoalCommon\ValueObject\Number\Natural;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class NaturalTest extends TestCase
{
    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidNativeArgument(): void
    {
        new Natural(-2);
    }
}
