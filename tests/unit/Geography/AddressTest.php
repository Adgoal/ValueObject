<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Geography;

use AdgoalCommon\ValueObject\Geography\Address;
use AdgoalCommon\ValueObject\Geography\Country;
use AdgoalCommon\ValueObject\Geography\CountryCode;
use AdgoalCommon\ValueObject\Geography\Street;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class AddressTest extends TestCase
{
    /** @var Address */
    protected $address;

    protected function setUp(): void
    {
        $this->address = new Address(
            new StringLiteral('Test Test'),
            new Street(new StringLiteral('via Manara'), new StringLiteral('3')),
            new StringLiteral(''),
            new StringLiteral('Altamura'),
            new StringLiteral('BARI'),
            new StringLiteral('70022'),
            new Country(CountryCode::IT())
        );
    }

    public function testFromNative(): void
    {
        $fromNativeAddress = Address::fromNative('Test Test', 'via Manara', '3', '', 'Altamura', 'BARI', '70022', 'IT');
        $this->assertTrue($this->address->sameValueAs($fromNativeAddress));
    }

    public function testInvalidFromNative(): void
    {
        $this->expectException(\BadMethodCallException::class);

        Address::fromNative('invalid');
    }

    public function testSameValueAs(): void
    {
        $address2 = new Address(
            new StringLiteral('Test Test'),
            new Street(new StringLiteral('via Manara'), new StringLiteral('3')),
            new StringLiteral(''),
            new StringLiteral('Altamura'),
            new StringLiteral('BARI'),
            new StringLiteral('70022'),
            new Country(CountryCode::IT())
        );

        $address3 = new Address(
            new StringLiteral('Test Test'),
            new Street(new StringLiteral('SP159'), new StringLiteral('km 4')),
            new StringLiteral(''),
            new StringLiteral('Altamura'),
            new StringLiteral('BARI'),
            new StringLiteral('70022'),
            new Country(CountryCode::IT())
        );

        $this->assertTrue($this->address->sameValueAs($address2));
        $this->assertTrue($address2->sameValueAs($this->address));
        $this->assertFalse($this->address->sameValueAs($address3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($this->address->sameValueAs($mock));
    }

    public function testGetName(): void
    {
        $name = new StringLiteral('Test Test');
        $this->assertTrue($this->address->getName()->sameValueAs($name));
    }

    public function testGetStreet(): void
    {
        $street = new Street(new StringLiteral('via Manara'), new StringLiteral('3'));
        $this->assertTrue($this->address->getStreet()->sameValueAs($street));
    }

    public function testGetDistrict(): void
    {
        $district = new StringLiteral('');
        $this->assertTrue($this->address->getDistrict()->sameValueAs($district));
    }

    public function testGetCity(): void
    {
        $city = new StringLiteral('Altamura');
        $this->assertTrue($this->address->getCity()->sameValueAs($city));
    }

    public function testGetRegion(): void
    {
        $region = new StringLiteral('BARI');
        $this->assertTrue($this->address->getRegion()->sameValueAs($region));
    }

    public function testGetPostalCode(): void
    {
        $code = new StringLiteral('70022');
        $this->assertTrue($this->address->getPostalCode()->sameValueAs($code));
    }

    public function testGetCountry(): void
    {
        $country = new Country(CountryCode::IT());
        $this->assertTrue($this->address->getCountry()->sameValueAs($country));
    }

    public function testToString(): void
    {
        $addressString = <<<ADDR
Test Test
3 via Manara
Altamura BARI 70022
Italy
ADDR;

        $this->assertSame($addressString, $this->address->__toString());
    }
}
