<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Structure;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Structure\KeyValuePair;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

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
        $this->assertTrue($this->keyValuePair->sameValueAs($fromNativePair));
    }

    public function testInvalidFromNative(): void
    {
        $this->expectException(\BadMethodCallException::class);

        KeyValuePair::fromNative('key', 'value', 'invalid');
    }

    public function testSameValueAs(): void
    {
        $keyValuePair2 = new KeyValuePair(new StringLiteral('key'), new StringLiteral('value'));
        $keyValuePair3 = new KeyValuePair(new StringLiteral('foo'), new StringLiteral('bar'));

        $this->assertTrue($this->keyValuePair->sameValueAs($keyValuePair2));
        $this->assertTrue($keyValuePair2->sameValueAs($this->keyValuePair));
        $this->assertFalse($this->keyValuePair->sameValueAs($keyValuePair3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($this->keyValuePair->sameValueAs($mock));
    }

    public function testGetKey(): void
    {
        $this->assertEquals('key', $this->keyValuePair->getKey());
    }

    public function testGetValue(): void
    {
        $this->assertEquals('value', $this->keyValuePair->getValue());
    }

    public function testToString(): void
    {
        $this->assertEquals('a:1:{s:3:"key";s:5:"value";}', $this->keyValuePair->__toString());
    }
}
