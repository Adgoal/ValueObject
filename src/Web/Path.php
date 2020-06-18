<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;

/**
 * Class Path.
 */
class Path extends StringLiteral
{
    /**
     * Path constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $filteredValue = parse_url($value, PHP_URL_PATH);

        if (!empty($value) && null === $filteredValue || strlen($filteredValue) !== strlen($value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid url path)']);
        }

        parent::__construct($filteredValue);
    }
}
