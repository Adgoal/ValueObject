<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Structure;

use AdgoalCommon\ValueObject\NullValue\NullValue;
use AdgoalCommon\ValueObject\Number\Integer;
use AdgoalCommon\ValueObject\Number\Natural;
use AdgoalCommon\ValueObject\Number\Real;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use InvalidArgumentException;
use SplFixedArray;

/**
 * Class Collection.
 *
 * @SuppressWarnings(PHPMD)
 */
class Collection implements ValueObjectInterface
{
    /**
     * SplFixedArray object of values.
     *
     * @var SplFixedArray
     */
    protected $items;

    /**
     * Returns a new Collection object.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $array = func_get_arg(0);
        $items = [];

        if (!is_iterable($array)) {
            throw new InvalidArgumentException('Invalid argument type, expected array.');
        }

        foreach ($array as $item) {
            $item = self::makeValueObject($item);
            $items[] = $item;
        }

        $fixedArray = SplFixedArray::fromArray($items);

        return new static($fixedArray);
    }

    /**
     * Make and return ValueObject from native value.
     *
     * @param mixed $item
     *
     * @return ValueObjectInterface
     */
    protected static function makeValueObject($item): ValueObjectInterface
    {
        if ($item instanceof ValueObjectInterface) {
            return $item;
        }

        if (is_iterable($item)) {
            return self::isAssocArray($item) ? Dictionary::fromNative($item) : static::fromNative($item);
        }

        if (is_int($item)) {
            $item = Integer::fromNative($item);
        } elseif (is_float($item)) {
            $item = Real::fromNative($item);
        } elseif (is_bool($item)) {
            $item = Boolean::fromNative($item);
        } elseif (null === $item) {
            $item = new NullValue();
        } else {
            $item = StringLiteral::fromNative((string) $item);
        }

        return $item;
    }

    /**
     * Collection constructor.
     *
     * @param SplFixedArray $items
     */
    public function __construct(SplFixedArray $items)
    {
        foreach ($items as $item) {
            if (false === $item instanceof ValueObjectInterface) {
                $type = is_object($item) ? get_class($item) : gettype($item);

                throw new InvalidArgumentException(sprintf('Passed SplFixedArray object must contains "ValueObjectInterface" objects only. "%s" given.', $type));
            }
        }

        $this->items = $items;
    }

    /**
     * Tells whether two Collection are equal by comparing their size and items (item order matters).
     *
     * @param ValueObjectInterface $collection
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $collection): bool
    {
        if (!$collection instanceof static) {
            return false;
        }

        if (false === $this->count()->sameValueAs($collection->count())) {
            return false;
        }
        $arrayCollection = $collection->toArray(false);

        foreach ($this->items as $index => $item) {
            if (!isset($arrayCollection[$index]) || false === $item->sameValueAs($arrayCollection[$index])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the number of objects in the collection.
     *
     * @return Natural
     */
    public function count(): Natural
    {
        return new Natural($this->items->count());
    }

    /**
     * Tells whether the Collection contains an object.
     *
     * @param ValueObjectInterface $object
     *
     * @return bool
     */
    public function contains(ValueObjectInterface $object): bool
    {
        foreach ($this->items as $item) {
            if ($item->sameValueAs($object)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return native value.
     *
     * @return mixed[]
     */
    public function toNative()
    {
        return $this->toArray();
    }

    /**
     * Returns a native array representation of the Collection.
     *
     * @param bool $native
     *
     * @return mixed[]
     *
     * @SuppressWarnings(PHPMD)
     */
    public function toArray(bool $native = true): array
    {
        $items = $this->items->toArray();

        if (false === $native) {
            return $items;
        }

        foreach ($items as &$item) {
            if ($item instanceof ValueObjectInterface) {
                $item = $item->toNative();
            }
        }

        return $items;
    }

    /**
     * Returns a native string representation of the Collection object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return serialize($this->toArray());
    }

    /**
     * Validate is associated array.
     *
     * @param iterable $array
     *
     * @return bool
     */
    protected static function isAssocArray(iterable $array): bool
    {
        $idx = 0;

        foreach ($array as $key => $val) {
            if ($key !== $idx) {
                return true;
            }
            ++$idx;
        }

        return false;
    }
}
