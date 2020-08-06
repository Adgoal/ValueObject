<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Number;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Number\Natural;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class NaturalTest extends TestCase
{
    public function testInvalidNativeArgument(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new Natural(-2);
    }
}
