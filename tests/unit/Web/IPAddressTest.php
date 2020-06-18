<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\IPAddress;
use AdgoalCommon\ValueObject\Web\IPAddressVersion;

class IPAddressTest extends TestCase
{
    public function testGetVersion(): void
    {
        $ip4 = new IPAddress('127.0.0.1');
        $this->assertSame(IPAddressVersion::IPV4, (string) $ip4->getVersion());

        $ip6 = new IPAddress('::1');
        $this->assertSame(IPAddressVersion::IPV6, (string) $ip6->getVersion());
    }

    public function testInvalidIPAddress(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);

        new IPAddress('invalid');
    }
}
