<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsBetween;

class IsBetweenTest extends TestCase
{

    public function testConstructor()
    {
        $isBetween = new IsBetween("a", 1, 2);

        self::assertEquals("a BETWEEN ? AND ?", $isBetween->build());
        self::assertTrue($isBetween->isConfigured());
        self::assertEquals([1, 2], $isBetween->values());
    }


    public function testNot()
    {
        $isBetween = new IsBetween("a", "b", "c");
        $isBetween->not();
        self::assertEquals("a NOT BETWEEN ? AND ?", $isBetween->build());
        self::assertTrue($isBetween->isConfigured());
        self::assertEquals(["b", "c"], $isBetween->values());
    }

    public function testMissingEnd()
    {
        $isBetween = new IsBetween("a", 1, null);

        self::assertEquals("a >= ?", $isBetween->build());
        self::assertTrue($isBetween->isConfigured());
        self::assertEquals([1], $isBetween->values());
    }

    public function testMissingStart()
    {
        $isBetween = new IsBetween("a", null, 2);

        self::assertEquals("a <= ?", $isBetween->build());
        self::assertTrue($isBetween->isConfigured());
        self::assertEquals([2], $isBetween->values());
    }

    public function testMissingEndNot()
    {
        $isBetween = new IsBetween("a", 1, null);
        $isBetween->not();
        self::assertEquals("a < ?", $isBetween->build());
        self::assertTrue($isBetween->isConfigured());
        self::assertEquals([1], $isBetween->values());
    }

    public function testMissingStartNot()
    {
        $isBetween = new IsBetween("a", null, 2);
        $isBetween->not();
        self::assertEquals("a > ?", $isBetween->build());
        self::assertTrue($isBetween->isConfigured());
        self::assertEquals([2], $isBetween->values());
    }

    public function testNotConfigured()
    {
        $this->expectException(Exception::class);
        $isBetween = new IsBetween("a", null, null);
        $isBetween->build();
    }

    public function testExpressionFull()
    {
        $isBetween = new IsBetween("a", new Expression("COS1"),new Expression("COS2"));

        self::assertEquals("a BETWEEN COS1 AND COS2", $isBetween->build());
    }

    public function testExpressionLess() {
        $isBetween = new IsBetween("a", null, new Expression("COS2"));

        self::assertEquals("a <= COS2", $isBetween->build());
    }

    public function testExpressionGreater() {
        $isBetween = new IsBetween("a", new Expression("COS1"), null);

        self::assertEquals("a >= COS1", $isBetween->build());
    }


}