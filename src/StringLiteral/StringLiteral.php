<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\StringLiteral;

use AdgoalCommon\ValueObject\ValueObjectInterface;

/**
 * Class StringLiteral.
 */
class StringLiteral implements ValueObjectInterface
{
    /**
     * String native value.
     *
     * @var string
     */
    protected $value;

    /**
     * Returns a StringLiteral object given a PHP native string as parameter.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a StringLiteral object given a PHP native string as parameter.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Returns the value of the string.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * Tells whether two string literals are equal by comparing their values.
     *
     * @param ValueObjectInterface $stringLiteral
     *
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $stringLiteral): bool
    {
        if (!$stringLiteral instanceof static) {
            return false;
        }

        return $this->toNative() === $stringLiteral->toNative();
    }

    /**
     * Tells whether the StringLiteral is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return '' === $this->toNative();
    }

    /**
     * Returns the string value itself.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toNative();
    }
}
