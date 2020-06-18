<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\FragmentIdentifier;
use AdgoalCommon\ValueObject\Web\NullFragmentIdentifier;

class FragmentIdentifierTest extends TestCase
{
    public function testValidFragmentIdentifier(): void
    {
        $fragment = new FragmentIdentifier('#id');

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\FragmentIdentifier', $fragment);
    }

    public function testNullFragmentIdentifier(): void
    {
        $fragment = new NullFragmentIdentifier();

        $this->assertInstanceOf('AdgoalCommon\ValueObject\Web\FragmentIdentifier', $fragment);
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidFragmentIdentifier(): void
    {
        new FragmentIdentifier('invalìd');
    }
}
