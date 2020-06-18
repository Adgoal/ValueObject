<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Structure\Dictionary;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\NullQueryString;
use AdgoalCommon\ValueObject\Web\QueryString;

class QueryStringTest extends TestCase
{
    public function testValidQueryString(): void
    {
        $query = new QueryString('?foo=bar');

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\QueryString', $query);
    }

    public function testEmptyQueryString(): void
    {
        $query = new NullQueryString();

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\QueryString', $query);

        $dictionary = $query->toDictionary();
        $this->assertInstanceOf('AdgoalCommon\ValueObject\Structure\Dictionary', $dictionary);
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidQueryString(): void
    {
        new QueryString('invalìd');
    }

    public function testToDictionary(): void
    {
        $query = new QueryString('?foo=bar&array[]=one&array[]=two');
        $dictionary = $query->toDictionary();

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Structure\Dictionary', $dictionary);

        $array = [
            'foo' => 'bar',
            'array' => [
                'one',
                'two',
            ],
        ];
        $expectedDictionary = Dictionary::fromNative($array);

        $this->assertTrue($expectedDictionary->sameValueAs($dictionary));
    }
}
