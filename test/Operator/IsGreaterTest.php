<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsGreater;

class IsGreaterTest extends TestCase
{

    public function testConstructor()
    {
       $isGreater = new IsGreater("a", "b");

       self::assertEquals("a > ?", $isGreater->build());
       self::assertTrue($isGreater->isConfigured());
       self::assertEquals(["b"], $isGreater->values());
    }


    public function testNot() {
        $isGreater = new IsGreater("a","b");
        $isGreater->not();
        self::assertEquals("a <= ?", $isGreater->build());
        self::assertTrue($isGreater->isConfigured());
        self::assertEquals(["b"], $isGreater->values());
    }

    public function testNotConfigured() {
        $this->expectException(Exception::class);
        $isGreater = new IsGreater("a",null);
        $isGreater->build();
    }


}