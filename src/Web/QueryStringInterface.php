<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\Structure\Dictionary;
use AdgoalCommon\ValueObject\ValueObjectInterface;

/**
 * Interface QueryStringInterface.
 */
interface QueryStringInterface extends ValueObjectInterface
{
    /**
     * @return Dictionary
     */
    public function toDictionary(): Dictionary;
}
