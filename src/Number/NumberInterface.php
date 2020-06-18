<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Number;

/**
 * Interface NumberInterface.
 */
interface NumberInterface
{
    /**
     * Returns a PHP native implementation of the Number value.
     *
     * @return mixed
     */
    public function toNative();
}
