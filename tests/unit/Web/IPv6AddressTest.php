<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\IPv6Address;

class IPv6AddressTest extends TestCase
{
    public function testValidIPv6Address(): void
    {
        $ip = new IPv6Address('::1');

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\IPv6Address', $ip);
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidIPv6Address(): void
    {
        new IPv6Address('127.0.0.1');
    }
}
