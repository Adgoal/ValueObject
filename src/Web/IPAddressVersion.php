<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\Enum\Enum;

/**
 * Class IPAddressVersion.
 */
class IPAddressVersion extends Enum
{
    public const IPV4 = 'IPv4';
    public const IPV6 = 'IPv6';
}
