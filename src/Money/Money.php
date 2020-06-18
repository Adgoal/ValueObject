<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Money;

use AdgoalCommon\ValueObject\Number\Integer as IntegerValueObject;
use AdgoalCommon\ValueObject\Number\Real;
use AdgoalCommon\ValueObject\Number\RoundingMode;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use Money\Currency as BaseCurrency;
use Money\Money as BaseMoney;

/**
 * Class Money.
 */
class Money implements ValueObjectInterface
{
    /**
     * Money\Money object.
     *
     * @var BaseMoney
     */
    protected $money;

    /**
     * Currency ValueObject.
     *
     * @var Currency
     */
    protected $currency;

    /**
     * Returns a Money object from native int amount and string currency code.
     *
     * @return static
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        $amount = new IntegerValueObject($args[0]);
        $currency = Currency::fromNative($args[1]);

        return new static($amount, $currency);
    }

    /**
     * Returns a Money object.
     *
     * @param IntegerValueObject $amount   Amount expressed in the smallest units of $currency (e.g. cents)
     * @param Currency           $currency Currency of the money object
     */
    public function __construct(IntegerValueObject $amount, Currency $currency)
    {
        $baseCurrency = new BaseCurrency($currency->getCode()->toNative());
        $this->money = new BaseMoney($amount->toNative(), $baseCurrency);
        $this->currency = $currency;
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
     *  Tells whether two Currency are equal by comparing their amount and currency.
     *
     * @param ValueObjectInterface $money
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $money): bool
    {
        if (!$money instanceof static) {
            return false;
        }

        return $this->getAmount()->sameValueAs($money->getAmount()) && $this->getCurrency()->sameValueAs($money->getCurrency());
    }

    /**
     * Returns money amount.
     *
     * @return IntegerValueObject
     */
    public function getAmount(): IntegerValueObject
    {
        return new IntegerValueObject((int) $this->money->getAmount());
    }

    /**
     * Returns money currency.
     *
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return clone $this->currency;
    }

    /**
     * Add an integer quantity to the amount and returns a new Money object.
     * Use a negative quantity for subtraction.
     *
     * @param IntegerValueObject $quantity Quantity to add
     *
     * @return Money
     */
    public function add(IntegerValueObject $quantity): self
    {
        $amount = new IntegerValueObject($this->getAmount()->toNative() + $quantity->toNative());

        return new self($amount, $this->getCurrency());
    }

    /**
     * Multiply the Money amount for a given number and returns a new Money object.
     * Use 0 < Real $multipler < 1 for division.
     *
     * @param Real              $multiplier
     * @param RoundingMode|null $roundingMode Rounding mode of the operation. Defaults to RoundingMode::HALF_UP.
     *
     * @return Money
     */
    public function multiply(Real $multiplier, ?RoundingMode $roundingMode = null): self
    {
        if (null === $roundingMode) {
            $roundingMode = RoundingMode::HALF_UP();
        }

        $amount = $this->getAmount()->toNative() * $multiplier->toNative();
        $roundedAmount = new IntegerValueObject(round($amount, 0, $roundingMode->toNative()));

        return new self($roundedAmount, $this->getCurrency());
    }

    /**
     * Returns a string representation of the Money value in format "CUR AMOUNT" (e.g.: EUR 1000).
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s %d', $this->getCurrency()->getCode()->__toString(), $this->getAmount()->toNative());
    }
}
