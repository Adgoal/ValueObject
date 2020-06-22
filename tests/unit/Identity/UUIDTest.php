<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Identity;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Identity\UUID;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class UUIDTest extends TestCase
{
    public function testGenerateAsString(): void
    {
        $uuidString = UUID::generateAsString();

        $this->assertRegexp('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $uuidString);
    }

    public function testFromNative(): void
    {
        $uuid1 = new UUID();
        $uuid2 = UUID::fromNative($uuid1->toNative());

        $this->assertTrue($uuid1->sameValueAs($uuid2));
    }

    public function testSameValueAs(): void
    {
        $uuid1 = new UUID();
        $uuid2 = clone $uuid1;
        $uuid3 = new UUID();

        $this->assertTrue($uuid1->sameValueAs($uuid2));
        $this->assertTrue($uuid2->sameValueAs($uuid1));
        $this->assertFalse($uuid1->sameValueAs($uuid3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($uuid1->sameValueAs($mock));
    }

    public function testInvalid(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);

        new UUID('invalid');
    }
}
