<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Util;

/**
 * Class Util.
 * Utility class for methods used all across the library.
 */
class Util
{
    /**
     * Tells whether two objects are of the same class.
     *
     * @param object $objectA
     * @param object $objectB
     *
     * @return bool
     */
    public static function classEquals($objectA, $objectB): bool
    {
        return get_class($objectA) === get_class($objectB);
    }

    /**
     * Returns full namespaced class as string.
     *
     * @param object $object
     *
     * @return string
     */
    public static function getClassAsString(object $object): string
    {
        return get_class($object);
    }
}
