<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Logical;

use AdgoalCommon\ValueObject\ValueObjectInterface;

/**
 * Class Boolean.
 */
class Boolean implements ValueObjectInterface
{
    /**
     * Bool value.
     *
     * @var bool
     */
    protected $value;

    /**
     * Returns a Boolean object given a PHP native string as parameter.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Boolean constructor.
     *
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * Returns the value of the bool.
     *
     * @return bool
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * Tells whether two boolean are equal by comparing their values.
     *
     * @param ValueObjectInterface $bool
     *
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $bool): bool
    {
        if (!$bool instanceof static) {
            return false;
        }

        return $this->toNative() === $bool->toNative();
    }

    /**
     * Returns the string value itself.
     *
     * @return string
     */
    public function __toString(): string
    {
        return true === $this->toNative() ? 'true' : 'false';
    }
}
