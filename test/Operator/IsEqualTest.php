<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsEqual;

class IsEqualTest extends TestCase
{

    public function testConstructor()
    {
       $isEqual = new IsEqual("a", "b");

       self::assertEquals("a = ?", $isEqual->build());
       self::assertTrue($isEqual->isConfigured());
       self::assertEquals(["b"], $isEqual->values());
    }

    public function testRightOperandArray() {
        $isEqual = new IsEqual("a", [1,2,3]);

        self::assertEquals("a IN (?,?,?)", $isEqual->build());
        self::assertEquals([1,2,3], $isEqual->values());
    }


    public function testNot() {
        $isEqual = new IsEqual("a","b");
        $isEqual->not();
        self::assertEquals("a != ?", $isEqual->build());
        self::assertTrue($isEqual->isConfigured());
        self::assertEquals(["b"], $isEqual->values());
    }

    public function testNotIn() {
        $isEqual = new IsEqual("a",[1,2,3]);
        $isEqual->not();
        self::assertEquals("a NOT IN (?,?,?)", $isEqual->build());
        self::assertTrue($isEqual->isConfigured());
        self::assertEquals([1,2,3], $isEqual->values());
    }

    public function testNotConfigured() {
        $this->expectException(Exception::class);
        $isEqual = new IsEqual("a",null);
        $isEqual->build();
    }

    public function testNotConfiguredArray() {
        $this->expectException(Exception::class);
        $isEqual = new IsEqual("a",[]);
        $isEqual->build();
    }

    public function testExpression() {
        $isEqual = new IsEqual("a", new Expression("NOW()"));
        self::assertEquals("a = NOW()", $isEqual->build());
        self::assertEquals([], $isEqual->values());
    }

}