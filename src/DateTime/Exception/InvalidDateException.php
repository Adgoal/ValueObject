<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime\Exception;

use Exception;

class InvalidDateException extends Exception
{
    /**
     * InvalidDateException constructor.
     *
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function __construct(int $year, int $month, int $day)
    {
        $date = sprintf('%d-%d-%d', $year, $month, $day);
        $message = sprintf('The date "%s" is invalid.', $date);
        parent::__construct($message);
    }
}
