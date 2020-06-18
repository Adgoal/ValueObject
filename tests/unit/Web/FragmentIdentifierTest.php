<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\FragmentIdentifier;
use AdgoalCommon\ValueObject\Web\FragmentIdentifierInterface;
use AdgoalCommon\ValueObject\Web\NullFragmentIdentifier;

class FragmentIdentifierTest extends TestCase
{
    public function testValidFragmentIdentifier(): void
    {
        $fragment = new FragmentIdentifier('#id');

        $this->assertInstanceOf(FragmentIdentifierInterface::class, $fragment);
    }

    public function testNullFragmentIdentifier(): void
    {
        $fragment = new NullFragmentIdentifier();

        $this->assertInstanceOf(FragmentIdentifierInterface::class, $fragment);
    }

    public function testInvalidFragmentIdentifier(): void
    {
        $this->expectException(InvalidNativeArgumentException::class);

        new FragmentIdentifier('invalìd');
    }
}
