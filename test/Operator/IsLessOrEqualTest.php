<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsLessOrEqual;

class IsLessOrEqualTest extends TestCase
{
    public function testConstructor()
    {
        $isLessOrEqual = new IsLessOrEqual("a", "b");

        self::assertEquals("a <= ?", $isLessOrEqual->build());
        self::assertTrue($isLessOrEqual->mustBeConsidered());
        self::assertEquals(["b"], $isLessOrEqual->values());
    }


    public function testNot()
    {
        $isLessOrEqual = new IsLessOrEqual("a", "b");
        $isLessOrEqual->not();
        self::assertEquals("a > ?", $isLessOrEqual->build());
        self::assertTrue($isLessOrEqual->mustBeConsidered());
        self::assertEquals(["b"], $isLessOrEqual->values());
    }

    public function testNotConfigured()
    {
        $this->expectException(Exception::class);
        $isLessOrEqual = new IsLessOrEqual("a", null);
        $isLessOrEqual->build();
    }

    public function testExpression()
    {
        $isLessOrEqual = new IsLessOrEqual("a", new Expression("NOW()"));
        self::assertEquals("a <= NOW()", $isLessOrEqual->build());
        self::assertEquals([], $isLessOrEqual->values());
    }
}
