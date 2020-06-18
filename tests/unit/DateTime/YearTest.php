<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\DateTime;

use AdgoalCommon\ValueObject\DateTime\Year;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;

class YearTest extends TestCase
{
    public function testNow(): void
    {
        $year = Year::now();
        $this->assertEquals(date('Y'), $year->toNative());
    }
}
