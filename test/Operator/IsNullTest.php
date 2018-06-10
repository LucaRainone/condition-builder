<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsNull;

class IsNullTest extends TestCase
{

    public function testConstructor()
    {
       $isNull = new IsNull("a");

       self::assertEquals("a IS NULL", $isNull->build());
       self::assertTrue($isNull->mustBeConsidered());
       self::assertEquals([], $isNull->values());

        $isNull = new IsNull("a", true);

        self::assertEquals("a IS NULL", $isNull->build());
        self::assertTrue($isNull->mustBeConsidered());
        self::assertEquals([], $isNull->values());

        $isNull = new IsNull("a", false);

        self::assertFalse($isNull->mustBeConsidered());
    }


    public function testNot() {
        $isNull = new IsNull("a");
        $isNull->not();
        self::assertEquals("a IS NOT NULL", $isNull->build());
        self::assertTrue($isNull->mustBeConsidered());
        self::assertEquals([], $isNull->values());
    }

    public function testNotConfigured() {
        $this->expectException(Exception::class);
        $isNull = new IsNull("a",false);
        $isNull->build();
    }


}