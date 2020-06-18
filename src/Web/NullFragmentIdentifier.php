<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

/**
 * Class NullFragmentIdentifier.
 */
class NullFragmentIdentifier extends FragmentIdentifier implements FragmentIdentifierInterface
{
    /**
     * Returns a new NullFragmentIdentifier.
     */
    public function __construct()
    {
        parent::__construct('');
    }
}
