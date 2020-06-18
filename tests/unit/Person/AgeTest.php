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
        $this->assertEquals(25, $age->toNative());
    }

    public function testSameValueAs(): void
    {
        $age1 = new Age(33);
        $age2 = new Age(33);
        $age3 = new Age(66);

        $this->assertTrue($age1->sameValueAs($age2));
        $this->assertTrue($age2->sameValueAs($age1));
        $this->assertFalse($age1->sameValueAs($age3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($age1->sameValueAs($mock));
    }

    public function testToString(): void
    {
        $age = new Age(54);
        $this->assertEquals('54', $age->__toString());
    }
}
