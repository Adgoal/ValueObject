<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Web\Path;

class PathTest extends TestCase
{
    public function testValidPath(): void
    {
        $pathString = '/path/to/resource.ext';
        $path = new Path($pathString);
        $this->assertEquals($pathString, $path->toNative());
    }

    /** @expectedException AdgoalCommon\ValueObject\Exception\InvalidNativeArgumentException */
    public function testInvalidPath(): void
    {
        new Path('//valid?');
    }
}
