<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Structure\Dictionary;

/**
 * Class QueryString.
 */
class QueryString extends StringLiteral implements QueryStringInterface
{
    /**
     * Returns a new QueryString.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^\?([\w\.\-[\]~&%+]+(=([\w\.\-~&%+]+)?)?)*$/', $value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid query string)']);
        }

        parent::__construct($value);
    }

    /**
     * Returns a Dictionary structured representation of the query string.
     *
     * @return Dictionary
     */
    public function toDictionary(): Dictionary
    {
        $data = [];
        $value = ltrim($this->toNative(), '?');
        parse_str($value, $data);

        return Dictionary::fromNative($data);
    }
}
