<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Money;

use AdgoalCommon\ValueObject\Money\Currency;
use AdgoalCommon\ValueObject\Money\CurrencyCode;
use AdgoalCommon\ValueObject\Money\Money;
use AdgoalCommon\ValueObject\Number\Integer;
use AdgoalCommon\ValueObject\Number\Real;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class MoneyTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeMoney = Money::fromNative(2100, 'EUR');
        $constructedMoney = new Money(new Integer(2100), new Currency(CurrencyCode::EUR()));

        self::assertTrue($fromNativeMoney->sameValueAs($constructedMoney));
    }

    public function testSameValueAs(): void
    {
        $eur = new Currency(CurrencyCode::EUR());
        $usd = new Currency(CurrencyCode::USD());

        $money1 = new Money(new Integer(1200), $eur);
        $money2 = new Money(new Integer(1200), $eur);
        $money3 = new Money(new Integer(34607), $usd);

        self::assertTrue($money1->sameValueAs($money2));
        self::assertTrue($money2->sameValueAs($money1));
        self::assertFalse($money1->sameValueAs($money3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($money1->sameValueAs($mock));
    }

    public function testGetAmount(): void
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $amount = $money->getAmount();

        self::assertInstanceOf(Integer::class, $amount);
        self::assertSame(1200, $amount->toNative());
    }

    public function testGetCurrency(): void
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $currency = $money->getCurrency();

        self::assertInstanceOf(Currency::class, $currency);
        self::assertSame('EUR', $currency->getCode()->toNative());
    }

    public function testAdd(): void
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $addendum = new Integer(156);

        $addedMoney = $money->add($addendum);

        self::assertEquals(1356, $addedMoney->getAmount()->toNative());
    }

    public function testAddNegative(): void
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $addendum = new Integer(-120);

        $addedMoney = $money->add($addendum);

        self::assertEquals(1080, $addedMoney->getAmount()->toNative());
    }

    public function testMultiply(): void
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $multiplier = new Real(1.2);

        $addedMoney = $money->multiply($multiplier);

        self::assertEquals(1440, $addedMoney->getAmount()->toNative());
    }

    public function testMultiplyInverse(): void
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);
        $multiplier = new Real(0.3);

        $addedMoney = $money->multiply($multiplier);

        self::assertEquals(360, $addedMoney->getAmount()->toNative());
    }

    public function testToString(): void
    {
        $eur = new Currency(CurrencyCode::EUR());
        $money = new Money(new Integer(1200), $eur);

        self::assertSame('EUR 1200', $money->__toString());
    }
}
