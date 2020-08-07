<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\IPv4Address;

class IPv4AddressTest extends TestCase
{
    public function testValidIPv4Address(): void
    {
        $ip = new IPv4Address('127.0.0.1');

        self::assertInstanceOf(IPv4Address::class, $ip);
    }

    public function testInvalidIPv4Address(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new IPv4Address('::1');
    }
}
