<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Structure;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use InvalidArgumentException;
use SplFixedArray;

/**
 * Class Dictionary.
 *
 * @SuppressWarnings(PHPMD)
 */
class Dictionary extends Collection
{
    /**
     * Returns a new Dictionary object.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $array = func_get_arg(0);

        if (!is_iterable($array)) {
            throw new InvalidArgumentException('Invalid argument type, expected array.');
        }
        $keyValuePairs = [];

        foreach ($array as $key => $item) {
            $key = new StringLiteral((string) $key);
            $item = self::makeValueObject($item);
            $keyValuePairs[] = new KeyValuePair($key, $item);
        }
        $fixedArray = SplFixedArray::fromArray($keyValuePairs);

        return new static($fixedArray);
    }

    /**
     * Returns a new Dictionary object.
     *
     * @param SplFixedArray $keyValuePairs
     */
    public function __construct(SplFixedArray $keyValuePairs)
    {
        foreach ($keyValuePairs as $keyValuePair) {
            if (false === $keyValuePair instanceof KeyValuePair) {
                $type = is_object($keyValuePair) ? get_class($keyValuePair) : gettype($keyValuePair);

                throw new InvalidArgumentException(sprintf('Passed SplFixedArray object must contains "KeyValuePair" objects only. "%s" given.', $type));
            }
        }

        parent::__construct($keyValuePairs);
    }

    /**
     * Returns a Collection of the keys.
     *
     * @return Collection
     */
    public function keys(): Collection
    {
        $count = $this->count()->toNative();
        $keysArray = new SplFixedArray($count);

        foreach ($this->items as $key => $item) {
            $keysArray->offsetSet($key, $item->getKey());
        }

        return new Collection($keysArray);
    }

    /**
     * Returns a Collection of the values.
     *
     * @return Collection
     */
    public function values(): Collection
    {
        $count = $this->count()->toNative();
        $valuesArray = new SplFixedArray($count);

        foreach ($this->items as $key => $item) {
            $valuesArray->offsetSet($key, $item->getValue());
        }

        return new Collection($valuesArray);
    }

    /**
     * Tells whether $object is one of the keys.
     *
     * @param ValueObjectInterface $object
     *
     * @return bool
     */
    public function containsKey(ValueObjectInterface $object): bool
    {
        $keys = $this->keys();

        return $keys->contains($object);
    }

    /**
     * Tells whether $object is one of the values.
     *
     * @param ValueObjectInterface $object
     *
     * @return bool
     */
    public function containsValue(ValueObjectInterface $object): bool
    {
        $values = $this->values();

        return $values->contains($object);
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
        $native = [];

        foreach ($items as $item) {
            /** @var KeyValuePair $item */
            [$key, $value] = $item->toArray();
            $native[$key] = $value;
        }

        return $native;
    }
}
