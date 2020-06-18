<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Person;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;

/**
 * Class PhoneNumber.
 */
class PhoneNumber extends StringLiteral
{
    public function __construct(string $value)
    {
        if (0 === preg_match('/^([0-9]+)$/i', $value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid phone number)']);
        }

        parent::__construct($value);
    }
}
