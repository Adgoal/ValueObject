<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\IPv6Address;

class IPv6AddressTest extends TestCase
{
    public function testValidIPv6Address(): void
    {
        $ip = new IPv6Address('::1');

        self::assertInstanceOf(IPv6Address::class, $ip);
    }

    public function testInvalidIPv6Address(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new IPv6Address('127.0.0.1');
    }
}
