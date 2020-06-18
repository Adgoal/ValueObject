<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\EmailAddress;

class EmailAddressTest extends TestCase
{
    public function testValidEmailAddress(): void
    {
        $email1 = new EmailAddress('foo@bar.com');
        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\EmailAddress', $email1);

        $email2 = new EmailAddress('foo@[120.0.0.1]');
        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\EmailAddress', $email2);
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidEmailAddress(): void
    {
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
        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\Domain', $domainPart);
    }
}
