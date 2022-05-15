<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsNotNull;

class IsNotNullTest extends TestCase
{
    public function testConstructor()
    {
        $isNull = new IsNotNull("a");

        self::assertEquals("a IS NOT NULL", $isNull->build());
        self::assertTrue($isNull->mustBeConsidered());
        self::assertEquals([], $isNull->values());

        $isNull = new IsNotNull("a", true);

        self::assertEquals("a IS NOT NULL", $isNull->build());
        self::assertTrue($isNull->mustBeConsidered());
        self::assertEquals([], $isNull->values());

        $isNull = new IsNotNull("a", false);

        self::assertFalse($isNull->mustBeConsidered());
    }


    public function testNot()
    {
        $isNull = new IsNotNull("a");
        $isNull->not();
        self::assertEquals("a IS NULL", $isNull->build());
        self::assertTrue($isNull->mustBeConsidered());
        self::assertEquals([], $isNull->values());
    }

    public function testNotConfigured()
    {
        $this->expectException(Exception::class);
        $isNull = new IsNotNull("a", false);
        $isNull->build();
    }
}
