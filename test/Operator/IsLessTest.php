<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsLess;

class IsLessTest extends TestCase
{

    public function testConstructor()
    {
       $isLess = new IsLess("a", "b");

       self::assertEquals("a < ?", $isLess->build());
       self::assertTrue($isLess->mustBeConsidered());
       self::assertEquals(["b"], $isLess->values());
    }


    public function testNot() {
        $isLess = new IsLess("a","b");
        $isLess->not();
        self::assertEquals("a >= ?", $isLess->build());
        self::assertTrue($isLess->mustBeConsidered());
        self::assertEquals(["b"], $isLess->values());
    }

    public function testNotConfigured() {
        $this->expectException(Exception::class);
        $isLess = new IsLess("a",null);
        $isLess->build();
    }

    public function testExpression() {
        $isLess = new IsLess("a", new Expression("NOW()"));
        self::assertEquals("a < NOW()", $isLess->build());
        self::assertEquals([], $isLess->values());
    }


}