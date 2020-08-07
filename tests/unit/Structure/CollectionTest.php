<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Structure;

use AdgoalCommon\ValueObject\Number\Integer;
use AdgoalCommon\ValueObject\Number\Natural;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Structure\Collection;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use InvalidArgumentException;
use SplFixedArray;

class CollectionTest extends TestCase
{
    /** @var Collection */
    protected $collection;

    protected function setUp(): void
    {
        $array = new SplFixedArray(3);
        $array->offsetSet(0, new StringLiteral('one'));
        $array->offsetSet(1, new StringLiteral('two'));
        $array->offsetSet(2, new Integer(3));

        $this->collection = new Collection($array);
    }

    public function testInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $array = SplFixedArray::fromArray(['one', 'two', 'three']);

        new Collection($array);
    }

    public function testFromNative(): void
    {
        $array = SplFixedArray::fromArray([
            'one',
            'two',
            [1, 2],
        ]);
        $fromNativeCollection = Collection::fromNative($array);

        $innerArray = new Collection(
            SplFixedArray::fromArray([
                    new Integer(1),
                    new Integer(2),
            ])
        );
        $array = SplFixedArray::fromArray([
            new StringLiteral('one'),
            new StringLiteral('two'),
            $innerArray,
        ]);
        $constructedCollection = new Collection($array);

        self::assertTrue($fromNativeCollection->sameValueAs($constructedCollection));
    }

    public function testSameValueAs(): void
    {
        $array = SplFixedArray::fromArray([
            new StringLiteral('one'),
            new StringLiteral('two'),
            new Integer(3),
        ]);
        $collection2 = new Collection($array);

        $array = SplFixedArray::fromArray([
            'one',
            'two',
            [1, 2],
        ]);
        $collection3 = Collection::fromNative($array);

        self::assertTrue($this->collection->sameValueAs($collection2));
        self::assertTrue($collection2->sameValueAs($this->collection));
        self::assertFalse($this->collection->sameValueAs($collection3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($this->collection->sameValueAs($mock));
    }

    public function testCount(): void
    {
        $three = new Natural(3);

        self::assertTrue($this->collection->count()->sameValueAs($three));
    }

    public function testContains(): void
    {
        $one = new StringLiteral('one');
        $ten = new StringLiteral('ten');

        self::assertTrue($this->collection->contains($one));
        self::assertFalse($this->collection->contains($ten));
    }

    public function testToArray(): void
    {
        $array = [
            'one',
            'two',
            3,
        ];

        self::assertEquals($array, $this->collection->toArray());
    }

    public function testToString(): void
    {
        self::assertEquals('a:3:{i:0;s:3:"one";i:1;s:3:"two";i:2;i:3;}', $this->collection->__toString());
    }
}
