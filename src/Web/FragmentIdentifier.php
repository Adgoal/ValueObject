<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;

/**
 * Class FragmentIdentifier.
 */
class FragmentIdentifier extends StringLiteral implements FragmentIdentifierInterface
{
    /**
     * Returns a new FragmentIdentifier.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^#[?%!$&\'()*+,;=a-zA-Z0-9-._~:@\/]*$/', $value)) {
            throw new InvalidNativeArgumentException($value, ['string (valid fragment identifier)']);
        }

        parent::__construct($value);
    }
}
