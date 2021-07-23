<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Climate;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Number\Natural;
use AdgoalCommon\ValueObject\ValueObjectInterface;

/**
 * Class RelativeHumidity.
 */
class RelativeHumidity extends Natural
{
    public const MIN = 0;

    public const MAX = 100;

    /**
     * Returns a new RelativeHumidity from native int value.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    /**
     * Returns a new RelativeHumidity object.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => ['min_range' => self::MIN, 'max_range' => self::MAX],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int (>='.self::MIN.', <='.self::MAX.')'], static::class);
        }

        parent::__construct($value);
    }
}
