<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\Structure\Dictionary;

/**
 * Interface QueryStringInterface.
 */
interface QueryStringInterface
{
    /**
     * @return Dictionary
     */
    public function toDictionary(): Dictionary;
}
