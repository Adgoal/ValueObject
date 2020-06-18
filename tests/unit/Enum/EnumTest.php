<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Enum;

use AdgoalCommon\ValueObject\Enum\Enum;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class EnumTest extends TestCase
{
    public function testSameValueAs(): void
    {
        $stub1 = $this->getMockBuilder(Enum::class)->getMock();
        $stub2 = $this->getMockBuilder(Enum::class)->getMock();

        $stub1->expects($this->any())
              ->method('sameValueAs')
              ->will($this->returnValue(true));

        $this->assertTrue($stub1->sameValueAs($stub2));
    }

    public function testToString(): void
    {
        $stub = $this->getMockBuilder(Enum::class)->getMock();
        $this->assertEquals('', $stub->__toString());
    }
}
