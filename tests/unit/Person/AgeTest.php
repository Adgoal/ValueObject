<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Person;

use AdgoalCommon\ValueObject\Person\Age;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class AgeTest extends TestCase
{
    public function testToNative(): void
    {
        $age = new Age(25);
        self::assertEquals(25, $age->toNative());
    }

    public function testSameValueAs(): void
    {
        $age1 = new Age(33);
        $age2 = new Age(33);
        $age3 = new Age(66);

        self::assertTrue($age1->sameValueAs($age2));
        self::assertTrue($age2->sameValueAs($age1));
        self::assertFalse($age1->sameValueAs($age3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($age1->sameValueAs($mock));
    }

    public function testToString(): void
    {
        $age = new Age(54);
        self::assertEquals('54', $age->__toString());
    }
}
