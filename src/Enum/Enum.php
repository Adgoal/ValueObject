<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Enum;

use AdgoalCommon\ValueObject\ValueObjectInterface;
use MabeEnum\Enum as BaseEnum;
use MabeEnum\EnumSerializableTrait;

/**
 * Class Enum.
 *
 * @psalm-suppress MissingImmutableAnnotation
 */
abstract class Enum extends BaseEnum implements ValueObjectInterface
{
    use EnumSerializableTrait;

    /**
     * Returns a new Enum object from passed value matching argument.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return static::get($value);
    }

    /**
     * Returns the PHP native value of the enum.
     *
     * @return mixed
     */
    public function toNative()
    {
        return $this->getValue();
    }

    /**
     * Tells whether two Enum objects are sameValueAs by comparing their values.
     *
     * @param ValueObjectInterface $enum
     *
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $enum): bool
    {
        if (!$enum instanceof static) {
            return false;
        }

        return $this->toNative() === $enum->toNative();
    }

    /**
     * Returns a native string representation of the Enum value.
     *
     * @return string
     *
     * @psalm-suppress MissingImmutableAnnotation
     */
    public function __toString(): string
    {
        return (string) $this->toNative();
    }
}
