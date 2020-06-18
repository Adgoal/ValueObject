<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\IPv4Address;

class IPv4AddressTest extends TestCase
{
    public function testValidIPv4Address(): void
    {
        $ip = new IPv4Address('127.0.0.1');

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\IPv4Address', $ip);
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidIPv4Address(): void
    {
        new IPv4Address('::1');
    }
}
