<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Geography\Country;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;

/**
 * Class Country.
 */
class CountryAlpha2 implements ValueObjectInterface
{
    /**
     * CountryCode ValueObject.
     *
     * @var CountryCodeAlpha2
     */
    protected $code;

    /**
     * Returns a new Country object given a native PHP string country code.
     *
     * @return self
     */
    public static function fromNative(): ValueObjectInterface
    {
        $codeString = func_get_arg(0);
        $code = CountryCodeAlpha2::byName($codeString);

        return new self($code);
    }

    /**
     * Returns a new Country object.
     *
     * @param CountryCodeAlpha2 $code
     */
    public function __construct(CountryCodeAlpha2 $code)
    {
        $this->code = $code;
    }

    /**
     * Return native value.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->__toString();
    }

    /**
     * Tells whether two Country are equal.
     *
     * @param ValueObjectInterface $country
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $country): bool
    {
        if (!$country instanceof static) {
            return false;
        }

        return $this->getCode()->sameValueAs($country->getCode());
    }

    /**
     * Returns country code.
     *
     * @return CountryCodeAlpha2
     */
    public function getCode(): CountryCodeAlpha2
    {
        return $this->code;
    }

    /**
     * Returns country name.
     *
     * @return StringLiteral
     */
    public function getName(): StringLiteral
    {
        $code = $this->getCode();

        return CountryCodeNameAlpha2::getName($code);
    }

    /**
     * Returns country name as native string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName()->toNative();
    }
}
