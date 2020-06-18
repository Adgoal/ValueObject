<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Util;

use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\Util\Util;

class UtilTest extends TestCase
{
    public function testClassEquals(): void
    {
        $util1 = new Util();
        $util2 = new Util();

        $this->assertTrue(Util::classEquals($util1, $util2));
        $this->assertFalse(Util::classEquals($util1, $this));
    }

    public function testGetClassAsString(): void
    {
        $util = new Util();
        $this->assertEquals('AdgoalCommon\ValueObject\Util\Util', Util::getClassAsString($util));
    }
}
