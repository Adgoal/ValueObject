<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Enum;

use AdgoalCommon\ValueObject\Enum\Enum;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class EnumTest extends TestCase
{
    final public function testSameValueAs(): void
    {
        $stub1 = $this->getMockBuilder(Enum::class)->disableOriginalConstructor()->getMock();
        $stub2 = $this->getMockBuilder(Enum::class)->disableOriginalConstructor()->getMock();

        $stub1
              ->method('sameValueAs')
              ->willReturn(true);

        self::assertTrue($stub1->sameValueAs($stub2));
    }

    public function testToString(): void
    {
        $stub = $this->getMockBuilder(Enum::class)->disableOriginalConstructor()->getMock();
        self::assertEquals('', $stub->__toString());
    }
}
