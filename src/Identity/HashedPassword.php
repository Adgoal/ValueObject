<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Identity;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;

class HashedPassword extends StringLiteral
{
    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidNativeArgumentException('hash', ['string (not empty)'], static::class);
        }

        parent::__construct($value);
    }

    /**
     * @param PlainPassword $plainPassword
     *
     * @return bool
     */
    public function isPasswordValid(PlainPassword $plainPassword): bool
    {
        return password_verify((string) $plainPassword, $this->value);
    }
}
