<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Identity;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;

class PlainPassword extends StringLiteral
{
    public const MUST_CONTAINS_LOWER_LETTER = 1;
    public const MUST_CONTAINS_UPPER_LETTER = 2;
    public const MUST_CONTAINS_DIGIT = 3;
    public const MUST_CONTAINS_SPECIAL_SYMBOL = 4;

    private const MIN_CHARS = 8;
    private const MAX_CHARS = 16;

    /**
     * @param string $value
     * @param int    $minChars
     * @param int    $maxChars
     * @param int[]  $rules
     */
    public function __construct(
        string $value,
        int $minChars = self::MIN_CHARS,
        int $maxChars = self::MAX_CHARS,
        array $rules = []
    ) {
        if (empty($value)) {
            throw new InvalidNativeArgumentException('password', ['string (not empty)'], static::class);
        }

        $this->validateContentLength($value, $minChars, $maxChars);
        $this->validateContent($value, $rules);

        parent::__construct($value);
    }

    /**
     * @param string $value
     * @param int    $minChars
     * @param int    $maxChars
     */
    private function validateContentLength(string $value, int $minChars, int $maxChars): void
    {
        if ($minChars > $maxChars) {
            throw new InvalidNativeArgumentException($minChars, ['int (min should be <= max'], static::class);
        }

        if (mb_strlen($value) < $minChars || mb_strlen($value) > $maxChars) {
            throw new InvalidNativeArgumentException(
                'password',
                [sprintf('string (length: >= %d, <=%d)', $minChars, $maxChars)],
                static::class
            );
        }
    }

    /**
     * @param string $value
     * @param int[]  $rules
     */
    private function validateContent(string $value, array $rules): void
    {
        if (in_array(self::MUST_CONTAINS_LOWER_LETTER, $rules) && !preg_match('/[a-z]/', $value)) {
            throw new InvalidNativeArgumentException('password', ['string (lower letter required)'], static::class);
        }

        if (in_array(self::MUST_CONTAINS_UPPER_LETTER, $rules) && !preg_match('/[A-Z]/', $value)) {
            throw new InvalidNativeArgumentException('password', ['string (upper letter required)'], static::class);
        }

        if (in_array(self::MUST_CONTAINS_DIGIT, $rules) && !preg_match('/[0-9]/', $value)) {
            throw new InvalidNativeArgumentException('password', ['string (digit required)'], static::class);
        }

        if (in_array(self::MUST_CONTAINS_SPECIAL_SYMBOL, $rules) && !preg_match('/[^a-z0-9 ]/i', $value)) {
            throw new InvalidNativeArgumentException('password', ['string (special symbol required)'], static::class);
        }
    }
}
