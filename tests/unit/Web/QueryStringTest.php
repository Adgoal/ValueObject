<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Structure\Dictionary;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\NullQueryString;
use AdgoalCommon\ValueObject\Web\QueryString;

class QueryStringTest extends TestCase
{
    public function testValidQueryString(): void
    {
        $query = new QueryString('?foo=bar');

        self::assertInstanceOf(QueryString::class, $query);
    }

    public function testEmptyQueryString(): void
    {
        $query = new NullQueryString();

        self::assertInstanceOf(StringLiteral::class, $query);

        $dictionary = $query->toDictionary();
        self::assertInstanceOf(Dictionary::class, $dictionary);
    }

    public function testInvalidQueryString(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new QueryString('invalìd');
    }

    public function testToDictionary(): void
    {
        $query = new QueryString('?foo=bar&array[]=one&array[]=two');
        $dictionary = $query->toDictionary();

        self::assertInstanceOf(Dictionary::class, $dictionary);

        $array = [
            'foo' => 'bar',
            'array' => [
                'one',
                'two',
            ],
        ];
        $expectedDictionary = Dictionary::fromNative($array);

        self::assertTrue($expectedDictionary->sameValueAs($dictionary));
    }
}
