<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Structure;

use AdgoalCommon\ValueObject\Number\Integer;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Structure\Collection;
use AdgoalCommon\ValueObject\Structure\Dictionary;
use AdgoalCommon\ValueObject\Structure\KeyValuePair;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class DictionaryTest extends TestCase
{
    /** @var Dictionary */
    protected $dictionary;

    protected function setUp(): void
    {
        $array = \SplFixedArray::fromArray([
            new KeyValuePair(new Integer(0), new StringLiteral('zero')),
            new KeyValuePair(new Integer(1), new StringLiteral('one')),
            new KeyValuePair(new Integer(2), new StringLiteral('two')),
        ]);

        $this->dictionary = new Dictionary($array);
    }

    public function testFromNative(): void
    {
        $constructedArray = \SplFixedArray::fromArray([
            new KeyValuePair(new StringLiteral('0'), new StringLiteral('zero')),
            new KeyValuePair(new StringLiteral('1'), new StringLiteral('one')),
            new KeyValuePair(new StringLiteral('2'), new StringLiteral('two')),
        ]);

        $fromNativeArray = \SplFixedArray::fromArray([
            'zero',
            'one',
            'two',
        ]);

        $constructedDictionary = new Dictionary($constructedArray);
        $fromNativeDictionary = Dictionary::fromNative($fromNativeArray);

        $this->assertTrue($constructedDictionary->sameValueAs($fromNativeDictionary));
    }

    public function testInvalidArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $array = \SplFixedArray::fromArray(['one', 'two', 'three']);

        new Dictionary($array);
    }

    public function testKeys(): void
    {
        $array = \SplFixedArray::fromArray([
            new Integer(0),
            new Integer(1),
            new Integer(2),
        ]);
        $keys = new Collection($array);

        $this->assertTrue($this->dictionary->keys()->sameValueAs($keys));
    }

    public function testValues(): void
    {
        $array = \SplFixedArray::fromArray([
            new StringLiteral('zero'),
            new StringLiteral('one'),
            new StringLiteral('two'),
        ]);
        $values = new Collection($array);

        $this->assertTrue($this->dictionary->values()->sameValueAs($values));
    }

    public function testContainsKey(): void
    {
        $one = new Integer(1);
        $ten = new Integer(10);

        $this->assertTrue($this->dictionary->containsKey($one));
        $this->assertFalse($this->dictionary->containsKey($ten));
    }

    public function testContainsValue(): void
    {
        $one = new StringLiteral('one');
        $ten = new StringLiteral('ten');

        $this->assertTrue($this->dictionary->containsValue($one));
        $this->assertFalse($this->dictionary->containsValue($ten));
    }
}
