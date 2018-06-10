<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsGreater;

class IsGreaterTest extends TestCase
{

    public function testConstructor()
    {
       $isGreater = new IsGreater("a", "b");

       self::assertEquals("a > ?", $isGreater->build());
       self::assertTrue($isGreater->mustBeConsidered());
       self::assertEquals(["b"], $isGreater->values());
    }


    public function testNot() {
        $isGreater = new IsGreater("a","b");
        $isGreater->not();
        self::assertEquals("a <= ?", $isGreater->build());
        self::assertTrue($isGreater->mustBeConsidered());
        self::assertEquals(["b"], $isGreater->values());
    }

    public function testNotConfigured() {
        $this->expectException(Exception::class);
        $isGreater = new IsGreater("a",null);
        $isGreater->build();
    }

    public function testExpression() {
        $isGreater = new IsGreater("a", new Expression("NOW()"));
        self::assertEquals("a > NOW()", $isGreater->build());
        self::assertEquals([], $isGreater->values());
    }

}