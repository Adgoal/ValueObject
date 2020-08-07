<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\Domain;
use AdgoalCommon\ValueObject\Web\Hostname;
use AdgoalCommon\ValueObject\Web\IPAddress;

class DomainTest extends TestCase
{
    public function testSpecifyType(): void
    {
        $ip = Domain::specifyType('127.0.0.1');
        $hostname = Domain::specifyType('example.com');

        self::assertInstanceOf(IPAddress::class, $ip);
        self::assertInstanceOf(Hostname::class, $hostname);
    }
}
