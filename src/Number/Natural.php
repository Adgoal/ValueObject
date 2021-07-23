<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Number;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;

/**
 * Class Natural.
 */
class Natural extends Integer
{
    /**
     * Returns a Natural object given a PHP native int as parameter.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $options = [
            'options' => [
                'min_range' => 0,
            ],
        ];

        $value = filter_var($value, FILTER_VALIDATE_INT, $options);

        if (false === $value) {
            throw new InvalidNativeArgumentException($value, ['int (>=0)'], static::class);
        }

        parent::__construct($value);
    }
}
