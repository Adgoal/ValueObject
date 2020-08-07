<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Person;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Person\PhoneNumber;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class PhoneNumberTest extends TestCase
{
    public function testToNative(): void
    {
        $phoneNumber = new PhoneNumber('375449876521');
        self::assertEquals('375449876521', $phoneNumber->toNative());
    }

    public function testSameValueAs(): void
    {
        $phoneNumber1 = new PhoneNumber('375449876521');
        $phoneNumber2 = new PhoneNumber('375449876521');
        $phoneNumber3 = new PhoneNumber('375449876522');

        self::assertTrue($phoneNumber1->sameValueAs($phoneNumber2));
        self::assertTrue($phoneNumber2->sameValueAs($phoneNumber1));
        self::assertFalse($phoneNumber1->sameValueAs($phoneNumber3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($phoneNumber1->sameValueAs($mock));
    }

    public function testIsEmpty(): void
    {
        $phoneNumber = new PhoneNumber('375449876521');
        self::assertFalse($phoneNumber->isEmpty());
    }

    public function testToString(): void
    {
        $phoneNumber = new PhoneNumber('375449876521');
        self::assertEquals('375449876521', (string) $phoneNumber);
    }

    public function testWrongPhoneNumber(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new PhoneNumber('375 (44) 987-65-21');
    }
}
