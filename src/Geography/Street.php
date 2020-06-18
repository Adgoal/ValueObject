<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Geography;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use BadMethodCallException;

/**
 * Class Street.
 */
class Street implements ValueObjectInterface
{
    /**
     * Street name ValueObject.
     *
     * @var StringLiteral
     */
    protected $name;

    /**
     * Street number ValueObject.
     *
     * @var StringLiteral
     */
    protected $number;

    /**
     *  Street Building, floor and unit ValueObject.
     *
     * @var StringLiteral
     */
    protected $elements;

    /**
     * Use properties corresponding placeholders: %name%, %number%, %elements%.
     *
     * @var StringLiteral __toString()
     */
    protected $format;

    /**
     * Returns a new Street from native PHP string name and number.
     *
     * @return Street
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        if (count($args) < 2) {
            throw new BadMethodCallException('You must provide from 2 to 4 arguments: 1) street name, 2) street number, 3) elements, 4) format (optional)');
        }

        $nameString = $args[0];
        $numberString = $args[1];
        $elementsString = $args[2] ?? null;
        $formatString = $args[3] ?? null;

        $name = new StringLiteral($nameString);
        $number = new StringLiteral($numberString);
        $elements = $elementsString ? new StringLiteral($elementsString) : null;
        $format = $formatString ? new StringLiteral($formatString) : null;

        return new self($name, $number, $elements, $format);
    }

    /**
     * Returns a new Street object.
     *
     * @param StringLiteral      $name
     * @param StringLiteral      $number
     * @param StringLiteral|null $elements
     * @param StringLiteral|null $format
     */
    public function __construct(StringLiteral $name, StringLiteral $number, ?StringLiteral $elements = null, ?StringLiteral $format = null)
    {
        $this->name = $name;
        $this->number = $number;

        if (null === $elements) {
            $elements = new StringLiteral('');
        }
        $this->elements = $elements;

        if (null === $format) {
            $format = new StringLiteral('%number% %name%');
        }
        $this->format = $format;
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
     * Tells whether two Street objects are equal.
     *
     * @param ValueObjectInterface $street
     *
     * @return bool
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $street): bool
    {
        if (!$street instanceof static) {
            return false;
        }

        return $this->getName()->sameValueAs($street->getName()) &&
               $this->getNumber()->sameValueAs($street->getNumber()) &&
               $this->getElements()->sameValueAs($street->getElements());
    }

    /**
     * Returns street name.
     *
     * @return StringLiteral
     */
    public function getName(): StringLiteral
    {
        return clone $this->name;
    }

    /**
     * Returns street number.
     *
     * @return StringLiteral
     */
    public function getNumber(): StringLiteral
    {
        return clone $this->number;
    }

    /**
     * Returns street elements.
     *
     * @return StringLiteral
     */
    public function getElements(): StringLiteral
    {
        return clone $this->elements;
    }

    /**
     * Returns a string representation of the StringLiteral in the format defined in the constructor.
     *
     * @return string
     */
    public function __toString(): string
    {
        $replacements = [
            '%name%' => $this->getName(),
            '%number%' => $this->getNumber(),
            '%elements%' => $this->getElements(),
        ];

        return (string) str_replace(array_keys($replacements), array_values($replacements), (string) $this->format);
    }
}
