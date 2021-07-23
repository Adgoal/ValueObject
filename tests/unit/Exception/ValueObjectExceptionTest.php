<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Exception;


use AdgoalCommon\ValueObject\Exception\ValueObjectException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class ValueObjectExceptionTest extends TestCase
{
    public function testChildClass(): void
    {
        try {
            throw new ValueObjectException('Test', TestCase::class);
        } catch (ValueObjectException $e) {
            self::assertEquals($e->getChildClass(), TestCase::class);
        }
    }
}
