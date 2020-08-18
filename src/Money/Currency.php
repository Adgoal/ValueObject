<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Money;

use AdgoalCommon\ValueObject\ValueObjectInterface;
use Money\Currency as BaseCurrency;

/**
 * Class Currency.
 */
class Currency implements ValueObjectInterface
{
    /**
     * Money\Currency object.
     *
     * @var BaseCurrency
     */
    protected $currency;

    /**
     * CurrencyCode ValueObject.
     *
     * @var CurrencyCode
     */
    protected $code;

    /**
     * Returns a new Currency object from native string currency code.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $codeAsString = func_get_arg(0);
        $code = CurrencyCode::get($codeAsString);

        return new static($code);
    }

    /**
     * Currency constructor.
     *
     * @param CurrencyCode $code
     */
    public function __construct(CurrencyCode $code)
    {
        $this->code = $code;
        $this->currency = new BaseCurrency($code->toNative());
    }

    /**
     * Return native value.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->getCode()->toNative();
    }

    /**
     * Tells whether two Currency are equal by comparing their names.
     *
     * @param ValueObjectInterface $currency
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $currency): bool
    {
        if (!$currency instanceof static) {
            return false;
        }

        return $this->getCode()->toNative() === $currency->getCode()->toNative();
    }

    /**
     * Returns currency code.
     *
     * @return CurrencyCode
     */
    public function getCode(): CurrencyCode
    {
        return $this->code;
    }

    /**
     * Returns string representation of the currency.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getCode()->__toString();
    }
}
