<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Person;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use Exception;

/**
 * Class Name.
 */
class Name implements ValueObjectInterface
{
    /**
     * First name ValueObject.
     *
     * @var StringLiteral
     */
    private $firstName;

    /**
     * Middle name ValueObject.
     *
     * @var StringLiteral
     */
    private $middleName;

    /**
     * Last name ValueObject.
     *
     * @var StringLiteral
     */
    private $lastName;

    /**
     * Returns a Name objects form PHP native values.
     *
     * @return Name
     */
    public static function fromNative(): ValueObjectInterface
    {
        $args = func_get_args();

        $firstName = new StringLiteral($args[0]);
        $middleName = new StringLiteral($args[1]);
        $lastName = new StringLiteral($args[2]);

        return new self($firstName, $middleName, $lastName);
    }

    /**
     * Returns a Name object.
     *
     * @param StringLiteral $firstName
     * @param StringLiteral $middleName
     * @param StringLiteral $lastName
     */
    public function __construct(StringLiteral $firstName, StringLiteral $middleName, StringLiteral $lastName)
    {
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
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
     * Returns the first name.
     *
     * @return StringLiteral
     */
    public function getFirstName(): StringLiteral
    {
        return $this->firstName;
    }

    /**
     * Returns the middle name.
     *
     * @return StringLiteral
     */
    public function getMiddleName(): StringLiteral
    {
        return $this->middleName;
    }

    /**
     * Returns the last name.
     *
     * @return StringLiteral
     */
    public function getLastName(): StringLiteral
    {
        return $this->lastName;
    }

    /**
     * Returns the full name.
     *
     * @return StringLiteral
     */
    public function getFullName(): StringLiteral
    {
        $fullNameString = $this->firstName.
            ($this->middleName->isEmpty() ? '' : ' '.$this->middleName).
            ($this->lastName->isEmpty() ? '' : ' '.$this->lastName);

        return new StringLiteral($fullNameString);
    }

    /**
     * Tells whether two names are equal by comparing their values.
     *
     * @param ValueObjectInterface $name
     *
     * @return bool
     *
     * @throws Exception
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $name): bool
    {
        if (!$name instanceof static) {
            return false;
        }

        return $this->getFullName()->toNative() === $name->getFullName()->toNative();
    }

    /**
     * Returns the full name.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getFullName();
    }
}
