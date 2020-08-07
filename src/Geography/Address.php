<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Geography;

use AdgoalCommon\ValueObject\Geography\Country\CountryAlpha2;
use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class Address.
 */
class Address implements ValueObjectInterface
{
    /**
     * Name of the addressee (natural person or company).
     *
     * @var StringLiteral
     */
    protected $name;

    /**
     * Street ValueObject.
     *
     * @var Street
     */
    protected $street;

    /**
     * District/City area.
     *
     * @var StringLiteral
     */
    protected $district;

    /**
     * City/Town/Village.
     *
     * @var StringLiteral
     */
    protected $city;

    /**
     * Region/County/State.
     *
     * @var StringLiteral
     */
    protected $region;

    /**
     * Postal code/P.O. Box/ZIP code.
     *
     * @var StringLiteral
     */
    protected $postalCode;

    /**
     * @var CountryAlpha2
     */
    protected $country;

    /**
     * Returns a new Address from native PHP arguments.
     *
     * @return self
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (8 !== count($args)) {
            throw new BadMethodCallException('You must provide exactly 8 arguments: 1) addressee name, 2) street name, 3) street number, 4) district, 5) city, 6) region, 7) postal code, 8) country code.');
        }

        $name = new StringLiteral($args[0]);
        $street = new Street(new StringLiteral($args[1]), new StringLiteral($args[2]));
        $district = new StringLiteral($args[3]);
        $city = new StringLiteral($args[4]);
        $region = new StringLiteral($args[5]);
        $postalCode = new StringLiteral($args[6]);
        $country = CountryAlpha2::fromNative($args[7]);

        return new self($name, $street, $district, $city, $region, $postalCode, $country);
    }

    /**
     * Returns a new Address object.
     *
     * @param StringLiteral $name
     * @param Street        $street
     * @param StringLiteral $district
     * @param StringLiteral $city
     * @param StringLiteral $region
     * @param StringLiteral $postalCode
     * @param CountryAlpha2 $country
     */
    public function __construct(StringLiteral $name, Street $street, StringLiteral $district, StringLiteral $city, StringLiteral $region, StringLiteral $postalCode, CountryAlpha2 $country)
    {
        $this->name = $name;
        $this->street = $street;
        $this->district = $district;
        $this->city = $city;
        $this->region = $region;
        $this->postalCode = $postalCode;
        $this->country = $country;
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
     * Tells whether two Address are equal.
     *
     * @param ValueObjectInterface $address
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $address): bool
    {
        if (!$address instanceof static) {
            return false;
        }

        return $this->getName()->sameValueAs($address->getName()) &&
               $this->getStreet()->sameValueAs($address->getStreet()) &&
               $this->getDistrict()->sameValueAs($address->getDistrict()) &&
               $this->getCity()->sameValueAs($address->getCity()) &&
               $this->getRegion()->sameValueAs($address->getRegion()) &&
               $this->getPostalCode()->sameValueAs($address->getPostalCode()) &&
               $this->getCountry()->sameValueAs($address->getCountry())
        ;
    }

    /**
     * Returns addressee name.
     *
     * @return StringLiteral
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns street.
     *
     * @return Street
     */
    public function getStreet(): Street
    {
        return clone $this->street;
    }

    /**
     * Returns district.
     *
     * @return StringLiteral
     */
    public function getDistrict(): StringLiteral
    {
        return clone $this->district;
    }

    /**
     * Returns city.
     *
     * @return StringLiteral
     */
    public function getCity(): StringLiteral
    {
        return clone $this->city;
    }

    /**
     * Returns region.
     *
     * @return StringLiteral
     */
    public function getRegion(): StringLiteral
    {
        return clone $this->region;
    }

    /**
     * Returns postal code.
     *
     * @return StringLiteral
     */
    public function getPostalCode(): StringLiteral
    {
        return clone $this->postalCode;
    }

    /**
     * Returns country.
     *
     * @return CountryAlpha2
     */
    public function getCountry(): CountryAlpha2
    {
        return clone $this->country;
    }

    /**
     * Returns a string representation of the Address in US standard format.
     *
     * @return string
     */
    public function __toString(): string
    {
        $format = <<<ADDR
%s
%s
%s %s %s
%s
ADDR;

        return sprintf($format,
            $this->getName()->__toString(),
            $this->getStreet()->__toString(),
            $this->getCity()->__toString(),
            $this->getRegion()->__toString(),
            $this->getPostalCode()->__toString(),
            $this->getCountry()->__toString()
        );
    }
}
