<?php

namespace rain1\ConditionBuilder\Operator\Expression\MySQL\Date\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\MySQL\Date\Date;

class DateTest extends TestCase
{

	public function testConstructor()
	{
		$date = new Date("2019-01-01");

		self::assertEquals("'2019-01-01'", "$date");
	}

	public function testNow()
	{
		self::assertEquals("NOW()", Date::now());
	}


}