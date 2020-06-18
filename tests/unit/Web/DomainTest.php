<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\Domain;

class DomainTest extends TestCase
{
    public function testSpecifyType(): void
    {
        $ip = Domain::specifyType('127.0.0.1');
        $hostname = Domain::specifyType('example.com');

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\IPAddress', $ip);
        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\Hostname', $hostname);
    }
}
