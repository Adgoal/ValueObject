<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;

/**
 * Class IPv6Address.
 */
class IPv6Address extends IPAddress
{
    /**
     * Returns a new IPv6Address.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $filteredValue = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);

        if (false === $filteredValue) {
            throw new InvalidNativeArgumentException($value, ['string (valid ipv6 address)']);
        }

        parent::__construct($filteredValue);
    }
}
