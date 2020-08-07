<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Person;

use AdgoalCommon\ValueObject\Person\Gender;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class GenderTest extends TestCase
{
    public function testToNative(): void
    {
        $gender = Gender::FEMALE();
        self::assertEquals(Gender::FEMALE, $gender->toNative());
    }

    public function testSameValueAs(): void
    {
        $male1 = Gender::MALE();
        $male2 = Gender::MALE();
        $other = Gender::OTHER();

        self::assertTrue($male1->sameValueAs($male2));
        self::assertTrue($male2->sameValueAs($male1));
        self::assertFalse($male1->sameValueAs($other));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($male1->sameValueAs($mock));
    }

    public function testToString(): void
    {
        $sex = Gender::FEMALE();
        self::assertEquals('female', $sex->__toString());
    }
}
