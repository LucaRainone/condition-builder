<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsNotEqual;

class IsNotEqualTest extends TestCase
{

    public function testConstructor()
    {
       $isNotEqual = new IsNotEqual("a", "b");

       self::assertEquals("a != ?", $isNotEqual->build());
       self::assertTrue($isNotEqual->mustBeConsidered());
       self::assertEquals(["b"], $isNotEqual->values());
    }

    public function testRightOperandArray() {
        $isNotEqual = new IsNotEqual("a", [1,2,3]);

        self::assertEquals("a NOT IN (?,?,?)", $isNotEqual->build());
        self::assertEquals([1,2,3], $isNotEqual->values());
    }


    public function testNot() {
        $isNotEqual = new IsNotEqual("a","b");
        $isNotEqual->not();
        self::assertEquals("a = ?", $isNotEqual->build());
        self::assertTrue($isNotEqual->mustBeConsidered());
        self::assertEquals(["b"], $isNotEqual->values());
    }

    public function testNotIn() {
        $isNotEqual = new IsNotEqual("a",[1,2,3]);
        $isNotEqual->not();
        self::assertEquals("a IN (?,?,?)", $isNotEqual->build());
        self::assertTrue($isNotEqual->mustBeConsidered());
        self::assertEquals([1,2,3], $isNotEqual->values());
    }

    public function testNotConfigured() {
        $this->expectException(Exception::class);
        $isNotEqual = new IsNotEqual("a",null);
        $isNotEqual->build();
    }

    public function testExpression() {
        $isNotEqual = new IsNotEqual("a", new Expression("NOW()"));
        self::assertEquals("a != NOW()", $isNotEqual->build());
        self::assertEquals([], $isNotEqual->values());
    }
}