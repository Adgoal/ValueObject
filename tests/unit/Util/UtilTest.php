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

        self::assertTrue(Util::classEquals($util1, $util2));
        self::assertFalse(Util::classEquals($util1, $this));
    }

    public function testGetClassAsString(): void
    {
        $util = new Util();
        self::assertEquals(Util::class, Util::getClassAsString($util));
    }
}
