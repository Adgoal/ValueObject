<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;

/**
 * Class NullFragmentIdentifier.
 */
class NullFragmentIdentifier extends StringLiteral implements FragmentIdentifierInterface
{
    /**
     * Returns a new NullFragmentIdentifier.
     */
    public function __construct()
    {
        parent::__construct('');
    }
}
