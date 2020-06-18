<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\NullValue;

use AdgoalCommon\ValueObject\Util\Util;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class NullValue.
 */
class NullValue implements ValueObjectInterface
{
    /**
     * @throws BadMethodCallException
     */
    public static function fromNative(): ValueObjectInterface
    {
        throw new BadMethodCallException('Cannot create a NullValue object via this method.');
    }

    /**
     * Return native value.
     *
     * @return null
     */
    public function toNative()
    {
        return null;
    }

    /**
     * Returns a new NullValue object.
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Tells whether two objects are both NullValue.
     *
     * @param ValueObjectInterface $null
     *
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $null): bool
    {
        return Util::classEquals($this, $null);
    }

    /**
     * Returns a string representation of the NullValue object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return '';
    }
}
