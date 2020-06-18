<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\PortNumber;

class PortNumberTest extends TestCase
{
    public function testValidPortNumber(): void
    {
        $port = new PortNumber(80);

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\PortNumber', $port);
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidPortNumber(): void
    {
        new PortNumber(65536);
    }
}
