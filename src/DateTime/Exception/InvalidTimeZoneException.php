<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\DateTime\Exception;

use Exception;

class InvalidTimeZoneException extends Exception
{
    /**
     * InvalidTimeZoneException constructor.
     *
     * @param mixed $name
     */
    public function __construct($name)
    {
        $message = sprintf('The timezone "%s" is invalid. Check "timezone_identifiers_list()" for valid values.', $name);
        parent::__construct($message);
    }
}
