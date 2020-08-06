<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\IPAddress;
use AdgoalCommon\ValueObject\Web\IPAddressVersion;

class IPAddressTest extends TestCase
{
    final public function testGetVersion(): void
    {
        $ip4 = new IPAddress('127.0.0.1');
        self::assertSame(IPAddressVersion::get(IPAddressVersion::IPV4), $ip4->getVersion());

        $ip6 = new IPAddress('::1');
        self::assertSame(IPAddressVersion::get(IPAddressVersion::IPV6), $ip6->getVersion());
    }

    final public function testInvalidIPAddress(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new IPAddress('invalid');
    }
}
