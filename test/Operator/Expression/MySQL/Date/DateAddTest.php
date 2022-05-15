<?php

namespace rain1\ConditionBuilder\Operator\Expression\MySQL\Date\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\MySQL\Date\DateAdd;

class DateAddTest extends TestCase
{
    public function testConstructor()
    {
        $date = new DateAdd("2019-01-01", 3, DateAdd::UNIT_DAY);

        self::assertEquals("DATE_ADD(\"2019-01-01\", INTERVAL 3 DAY)", "$date");
    }

    public function testConstants()
    {
        self::assertEquals("SECOND", DateAdd::UNIT_SECOND);
        self::assertEquals("MINUTE", DateAdd::UNIT_MINUTE);
        self::assertEquals("HOUR", DateAdd::UNIT_HOUR);
        self::assertEquals("DAY", DateAdd::UNIT_DAY);
        self::assertEquals("MONTH", DateAdd::UNIT_MONTH);
        self::assertEquals("YEAR", DateAdd::UNIT_YEAR);
    }
}
