<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Person;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Person\EmailAddress;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\Domain;

class EmailAddressTest extends TestCase
{
    public function testValidEmailAddress(): void
    {
        $email1 = new EmailAddress('foo@bar.com');
        $this->assertInstanceOf(EmailAddress::class, $email1);

        $email2 = new EmailAddress('foo@[120.0.0.1]');
        $this->assertInstanceOf(EmailAddress::class, $email2);
    }

    public function testInvalidEmailAddress(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);

        new EmailAddress('invalid');
    }

    public function testGetLocalPart(): void
    {
        $email = new EmailAddress('foo@bar.baz');
        $localPart = $email->getLocalPart();

        $this->assertEquals('foo', $localPart->toNative());
    }

    public function testGetDomainPart(): void
    {
        $email = new EmailAddress('foo@bar.com');
        $domainPart = $email->getDomainPart();

        $this->assertEquals('bar.com', $domainPart->toNative());
        $this->assertInstanceOf(Domain::class, $domainPart);
    }
}
