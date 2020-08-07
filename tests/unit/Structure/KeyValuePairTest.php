<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Structure;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Structure\KeyValuePair;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use BadMethodCallException;

class KeyValuePairTest extends TestCase
{
    /** @var KeyValuePair */
    protected $keyValuePair;

    protected function setUp(): void
    {
        $this->keyValuePair = new KeyValuePair(new StringLiteral('key'), new StringLiteral('value'));
    }

    public function testFromNative(): void
    {
        $fromNativePair = KeyValuePair::fromNative('key', 'value');
        self::assertTrue($this->keyValuePair->sameValueAs($fromNativePair));
    }

    public function testInvalidFromNative(): void
    {
        $this->expectException(BadMethodCallException::class);
        KeyValuePair::fromNative('key', 'value', 'invalid');
    }

    public function testSameValueAs(): void
    {
        $keyValuePair2 = new KeyValuePair(new StringLiteral('key'), new StringLiteral('value'));
        $keyValuePair3 = new KeyValuePair(new StringLiteral('foo'), new StringLiteral('bar'));

        self::assertTrue($this->keyValuePair->sameValueAs($keyValuePair2));
        self::assertTrue($keyValuePair2->sameValueAs($this->keyValuePair));
        self::assertFalse($this->keyValuePair->sameValueAs($keyValuePair3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($this->keyValuePair->sameValueAs($mock));
    }

    public function testGetKey(): void
    {
        self::assertEquals('key', $this->keyValuePair->getKey());
    }

    public function testGetValue(): void
    {
        self::assertEquals('value', $this->keyValuePair->getValue());
    }

    public function testToString(): void
    {
        self::assertEquals('a:2:{i:0;s:3:"key";i:1;s:5:"value";}', $this->keyValuePair->__toString());
    }
}
