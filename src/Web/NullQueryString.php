<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Structure\Dictionary;

/**
 * Class NullQueryString.
 */
class NullQueryString extends StringLiteral implements QueryStringInterface
{
    /**
     * Returns a new NullQueryString.
     */
    public function __construct()
    {
        parent::__construct('');
    }

    public function toDictionary(): Dictionary
    {
        return Dictionary::fromNative([]);
    }
}
