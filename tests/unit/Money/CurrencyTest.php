<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Money;

use AdgoalCommon\ValueObject\Money\Currency;
use AdgoalCommon\ValueObject\Money\CurrencyCode;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class CurrencyTest extends TestCase
{
    public function testFromNative(): void
    {
        $fromNativeCurrency = Currency::fromNative('EUR');
        $constructedCurrency = new Currency(CurrencyCode::EUR());

        self::assertTrue($fromNativeCurrency->sameValueAs($constructedCurrency));
    }

    public function testSameValueAs(): void
    {
        $eur1 = new Currency(CurrencyCode::EUR());
        $eur2 = new Currency(CurrencyCode::EUR());
        $usd = new Currency(CurrencyCode::USD());

        self::assertTrue($eur1->sameValueAs($eur2));
        self::assertTrue($eur2->sameValueAs($eur1));
        self::assertFalse($eur1->sameValueAs($usd));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($eur1->sameValueAs($mock));
    }

    public function testGetCode(): void
    {
        $cad = new Currency(CurrencyCode::CAD());

        self::assertInstanceOf(CurrencyCode::class, $cad->getCode());
        self::assertSame('CAD', $cad->getCode()->toNative());
    }

    public function testToString(): void
    {
        $eur = new Currency(CurrencyCode::EUR());

        self::assertSame('EUR', $eur->__toString());
    }
}
