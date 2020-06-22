<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Structure;

use AdgoalCommon\ValueObject\Number\Integer;
use AdgoalCommon\ValueObject\Number\Natural;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Structure\Collection;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class CollectionTest extends TestCase
{
    /** @var Collection */
    protected $collection;

    protected function setUp(): void
    {
        $array = new \SplFixedArray(3);
        $array->offsetSet(0, new StringLiteral('one'));
        $array->offsetSet(1, new StringLiteral('two'));
        $array->offsetSet(2, new Integer(3));

        $this->collection = new Collection($array);
    }

    public function testInvalidArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $array = \SplFixedArray::fromArray(['one', 'two', 'three']);

        new Collection($array);
    }

    public function testFromNative(): void
    {
        $array = \SplFixedArray::fromArray([
            'one',
            'two',
            ['1', '2'],
        ]);
        $fromNativeCollection = Collection::fromNative($array);

        $innerArray = new Collection(
            \SplFixedArray::fromArray([
                new StringLiteral('1'),
                new StringLiteral('2'),
            ])
        );
        $array = \SplFixedArray::fromArray([
            new StringLiteral('one'),
            new StringLiteral('two'),
            $innerArray,
        ]);
        $constructedCollection = new Collection($array);

        $this->assertTrue($fromNativeCollection->sameValueAs($constructedCollection));
    }

    public function testSameValueAs(): void
    {
        $array = \SplFixedArray::fromArray([
            new StringLiteral('one'),
            new StringLiteral('two'),
            new Integer(3),
        ]);
        $collection2 = new Collection($array);

        $array = \SplFixedArray::fromArray([
            'one',
            'two',
            [1, 2],
        ]);
        $collection3 = Collection::fromNative($array);

        $this->assertTrue($this->collection->sameValueAs($collection2));
        $this->assertTrue($collection2->sameValueAs($this->collection));
        $this->assertFalse($this->collection->sameValueAs($collection3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($this->collection->sameValueAs($mock));
    }

    public function testCount(): void
    {
        $three = new Natural(3);

        $this->assertTrue($this->collection->count()->sameValueAs($three));
    }

    public function testContains(): void
    {
        $one = new StringLiteral('one');
        $ten = new StringLiteral('ten');

        $this->assertTrue($this->collection->contains($one));
        $this->assertFalse($this->collection->contains($ten));
    }

    public function testToArray(): void
    {
        $array = [
            (new StringLiteral('one'))->toNative(),
            (new StringLiteral('two'))->toNative(),
            (new Integer(3))->toNative(),
        ];

        $this->assertEquals($array, $this->collection->toArray());
    }

    public function testToString(): void
    {
        $this->assertEquals('a:3:{i:0;s:3:"one";i:1;s:3:"two";i:2;i:3;}', $this->collection->__toString());
    }
}
