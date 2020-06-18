<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject;

/**
 * Interface ValueObjectInterface.
 */
interface ValueObjectInterface
{
    /**
     * Returns a object taking PHP native value(s) as argument(s).
     *
     * @return ValueObjectInterface
     */
    public static function fromNative(): self;

    /**
     * Return native value.
     *
     * @return mixed
     */
    public function toNative();

    /**
     * Compare two ValueObjectInterface and tells whether they can be considered equal.
     *
     * @param ValueObjectInterface $valueObject
     *
     * @return bool
     */
    public function sameValueAs(self $valueObject): bool;

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function __toString(): string;
}
