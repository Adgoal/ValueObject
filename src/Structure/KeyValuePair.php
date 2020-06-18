<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Structure;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class KeyValuePair.
 */
class KeyValuePair implements ValueObjectInterface
{
    /**
     * Key ValueObjectInterface.
     *
     * @var ValueObjectInterface
     */
    protected $key;

    /**
     * Value ValueObjectInterface.
     *
     * @var ValueObjectInterface
     */
    protected $value;

    /**
     * Returns a KeyValuePair from native PHP arguments evaluated as strings.
     *
     * @return self
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (2 !== count($args)) {
            throw new BadMethodCallException('This methods expects two arguments. One for the key and one for the value.');
        }
        $keyString = (string) $args[0];
        $valueString = (string) $args[1];
        $key = new StringLiteral($keyString);
        $value = new StringLiteral($valueString);

        return new self($key, $value);
    }

    /**
     * Returns a KeyValuePair.
     *
     * @param ValueObjectInterface $key
     * @param ValueObjectInterface $value
     */
    public function __construct(ValueObjectInterface $key, ValueObjectInterface $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Return native value.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->__toString();
    }

    /**
     * Tells whether two KeyValuePair are equal.
     *
     * @param ValueObjectInterface $keyValuePair
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $keyValuePair): bool
    {
        if (!$keyValuePair instanceof static) {
            return false;
        }

        return $this->getKey()->sameValueAs($keyValuePair->getKey()) && $this->getValue()->sameValueAs($keyValuePair->getValue());
    }

    /**
     * Returns key.
     *
     * @return ValueObjectInterface
     */
    public function getKey(): ValueObjectInterface
    {
        return clone $this->key;
    }

    /**
     * Returns value.
     *
     * @return ValueObjectInterface
     */
    public function getValue(): ValueObjectInterface
    {
        return clone $this->value;
    }

    /**
     * Returns a string representation of the KeyValuePair in format "$key => $value".
     *
     * @return string
     */
    public function __toString(): string
    {
        return serialize($this->toArray());
    }

    /**
     * Return array of key and value.
     *
     * @return string[]
     */
    public function toArray(): array
    {
        return [$this->getKey()->toNative() => $this->getValue()->toNative()];
    }
}
