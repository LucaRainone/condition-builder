<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsLike;

class IsLikeTest extends TestCase
{
    public function testConstructor()
    {
        $isLike = new IsLike("a", "b");

        self::assertEquals("a LIKE ?", $isLike->build());
        self::assertTrue($isLike->mustBeConsidered());
        self::assertEquals(["b"], $isLike->values());
    }


    public function testNot()
    {
        $isLike = new IsLike("a", "b");
        $isLike->not();
        self::assertEquals("a NOT LIKE ?", $isLike->build());
        self::assertTrue($isLike->mustBeConsidered());
        self::assertEquals(["b"], $isLike->values());
    }

    public function testNotConfigured()
    {
        $this->expectException(Exception::class);
        $isLike = new IsLike("a", null);
        $isLike->build();
    }

    public function testExpression()
    {
        $isLike = new IsLike("a", new Expression("NOW()"));
        self::assertEquals("a LIKE NOW()", $isLike->build());
        self::assertEquals([], $isLike->values());
    }
}
