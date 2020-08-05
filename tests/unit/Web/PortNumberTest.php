<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\PortNumber;

class PortNumberTest extends TestCase
{
    public function testValidPortNumber(): void
    {
        $port = new PortNumber(80);

        self::assertInstanceOf(PortNumber::class, $port);
    }

    public function testInvalidPortNumber(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new PortNumber(65536);
    }
}
