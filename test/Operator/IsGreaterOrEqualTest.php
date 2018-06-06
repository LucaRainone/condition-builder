<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsGreaterOrEqual;

class IsGreaterOrEqualTest extends TestCase
{

    public function testConstructor()
    {
       $isGreaterOrEqual = new IsGreaterOrEqual("a", "b");

       self::assertEquals("a >= ?", $isGreaterOrEqual->build());
       self::assertTrue($isGreaterOrEqual->isConfigured());
       self::assertEquals(["b"], $isGreaterOrEqual->values());
    }


    public function testNot() {
        $isGreaterOrEqual = new IsGreaterOrEqual("a","b");
        $isGreaterOrEqual->not();
        self::assertEquals("a < ?", $isGreaterOrEqual->build());
        self::assertTrue($isGreaterOrEqual->isConfigured());
        self::assertEquals(["b"], $isGreaterOrEqual->values());
    }

    public function testNotConfigured() {
        $this->expectException(Exception::class);
        $isGreaterOrEqual = new IsGreaterOrEqual("a",null);
        $isGreaterOrEqual->build();
    }


}