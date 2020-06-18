<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Person;

use AdgoalCommon\ValueObject\Enum\Enum;

/**
 * Class Gender.
 *
 * @method static MALE()
 * @method static FEMALE()
 * @method static OTHER()
 */
class Gender extends Enum
{
    public const MALE = 'male';
    public const FEMALE = 'female';
    public const OTHER = 'other';
}
