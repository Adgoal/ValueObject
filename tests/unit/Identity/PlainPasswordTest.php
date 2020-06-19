<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Identity;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Identity\PlainPassword;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;

class PlainPasswordTest extends TestCase
{
    public function testToNative(): void
    {
        $plainPassword = new PlainPassword('sdlkg549F(#$');
        $this->assertEquals('sdlkg549F(#$', $plainPassword->toNative());
    }

    public function testSameValueAs(): void
    {
        $plainPassword1 = new PlainPassword('sdlkg549F(#$');
        $plainPassword2 = new PlainPassword('sdlkg549F(#$');
        $plainPassword3 = new PlainPassword('sdlkg549F(#$#');

        $this->assertTrue($plainPassword1->sameValueAs($plainPassword2));
        $this->assertTrue($plainPassword2->sameValueAs($plainPassword1));
        $this->assertFalse($plainPassword1->sameValueAs($plainPassword3));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($plainPassword1->sameValueAs($mock));
    }

    public function testIsEmpty(): void
    {
        $plainPassword = new PlainPassword('sdlkg549F(#$');
        $this->assertFalse($plainPassword->isEmpty());
    }

    public function testToString(): void
    {
        $plainPassword = new PlainPassword('sdlkg549F(#$');
        $this->assertEquals('sdlkg549F(#$', (string) $plainPassword);
    }

    public function testWrongEmptyPassword(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new PlainPassword('');
    }

    public function testMinCharsGreaterThanMaxChars(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new PlainPassword('sdlkg549F(#$', 16, 6);
    }

    public function testPasswordLengthLessThanMinChars(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new PlainPassword('sdlk', 6, 16);
    }

    public function testPasswordLengthGreaterThanMaxChars(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new PlainPassword('sdlk', 2, 3);
    }

    /**
     * @dataProvider passwordFormatProvider
     *
     * @param string $password
     * @param int[]  $rules
     */
    public function testPasswordFormats(string $password, array $rules): void
    {
        $this->expectException(InvalidNativeArgumentException::class);
        new PlainPassword($password, 6, 16, $rules);
    }

    /**
     * @return mixed[]
     */
    public function passwordFormatProvider(): array
    {
        return [
            'lower required' => ['ABCDEF', [PlainPassword::MUST_CONTAINS_LOWER_LETTER]],
            'upper required' => ['abcdef', [PlainPassword::MUST_CONTAINS_UPPER_LETTER]],
            'digit required' => ['abcdef', [PlainPassword::MUST_CONTAINS_DIGIT]],
            'special required' => ['abCD69', [PlainPassword::MUST_CONTAINS_SPECIAL_SYMBOL]],
            'lower and upper required' => ['abcdef', [
                PlainPassword::MUST_CONTAINS_LOWER_LETTER,
                PlainPassword::MUST_CONTAINS_UPPER_LETTER,
            ]],
        ];
    }
}
