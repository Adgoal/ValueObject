<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

/**
 * Class NullQueryString.
 */
class NullQueryString extends QueryString implements QueryStringInterface
{
    /**
     * Returns a new NullQueryString.
     */
    public function __construct()
    {
        parent::__construct('');
    }
}
