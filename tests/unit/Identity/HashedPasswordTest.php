<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Identity;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Identity\HashedPassword;
use AdgoalCommon\ValueObject\Identity\PlainPassword;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class HashedPasswordTest extends TestCase
{
    public function testToNative(): void
    {
        $plainPassword = new PlainPassword('sdlkg549F(#$');
        $hash = password_hash($plainPassword->toNative(), PASSWORD_BCRYPT);
        $hashedPassword = new HashedPassword((string) $hash);
        self::assertEquals($hash, $hashedPassword->toNative());
    }

    public function testSameValueAs(): void
    {
        $plainPassword1 = new PlainPassword('sdlkg549F(#$');
        $plainPassword2 = new PlainPassword('sdlkg549F(#$#');
        $hash1 = password_hash($plainPassword1->toNative(), PASSWORD_BCRYPT);
        $hash2 = password_hash($plainPassword2->toNative(), PASSWORD_BCRYPT);

        $hashedPassword1 = new HashedPassword((string) $hash1);
        $hashedPassword2 = new HashedPassword((string) $hash1);
        $hashedPassword3 = new HashedPassword((string) $hash2);

        self::assertTrue($hashedPassword1->sameValueAs($hashedPassword2));
        self::assertTrue($hashedPassword2->sameValueAs($hashedPassword1));
        self::assertFalse($hashedPassword1->sameValueAs($hashedPassword3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        self::assertFalse($hashedPassword1->sameValueAs($mock));
    }

    public function testIsEmpty(): void
    {
        $plainPassword = new PlainPassword('sdlkg549F(#$');
        $hash = password_hash($plainPassword->toNative(), PASSWORD_BCRYPT);
        $hashedPassword = new HashedPassword((string) $hash);
        self::assertFalse($hashedPassword->isEmpty());
    }

    public function testToString(): void
    {
        $plainPassword = new PlainPassword('sdlkg549F(#$');
        $hash = password_hash($plainPassword->toNative(), PASSWORD_BCRYPT);
        $hashedPassword = new HashedPassword((string) $hash);
        self::assertEquals($hash, (string) $hashedPassword);
    }

    public function testIsPasswordValid(): void
    {
        $plainPassword = new PlainPassword('sdlkg549F(#$');
        $hash = password_hash($plainPassword->toNative(), PASSWORD_BCRYPT);
        $hashedPassword = new HashedPassword((string) $hash);

        self::assertTrue($hashedPassword->isPasswordValid($plainPassword));
    }

    public function testIsPasswordInvalid(): void
    {
        $plainPassword = new PlainPassword('sdlkg549F(#$');
        $hash = password_hash($plainPassword->toNative(), PASSWORD_BCRYPT);
        $hashedPassword = new HashedPassword((string) $hash);

        $invaalidPlainPassword = new PlainPassword('sdlkg549F(#$#');
        self::assertFalse($hashedPassword->isPasswordValid($invaalidPlainPassword));
    }

    public function testWrongEmptyPassword(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new HashedPassword('');
    }
}
