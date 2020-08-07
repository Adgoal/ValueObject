<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\Hostname;

class HostnameTest extends TestCase
{
    public function testInvalidHostname(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new Hostname('inv@lìd');
    }
}
