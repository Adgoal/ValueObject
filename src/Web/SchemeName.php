<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;

/**
 * Class SchemeName.
 */
class SchemeName extends StringLiteral
{
    /**
     * Returns a SchemeName.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^[a-z]([a-z0-9\+\.-]+)?$/i', $value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid scheme name)'], static::class);
        }

        parent::__construct($value);
    }
}
