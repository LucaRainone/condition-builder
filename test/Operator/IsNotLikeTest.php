<?php

namespace rain1\ConditionBuilder\Operator\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Operator\Exception;
use rain1\ConditionBuilder\Operator\IsNotLike;

class IsNotLikeTest extends TestCase
{
    public function testConstructor()
    {
        $isNotLike = new IsNotLike("a", "b");

        self::assertEquals("a NOT LIKE ?", $isNotLike->build());
        self::assertTrue($isNotLike->mustBeConsidered());
        self::assertEquals(["b"], $isNotLike->values());
    }


    public function testNot()
    {
        $isNotLike = new IsNotLike("a", "b");
        $isNotLike->not();
        self::assertEquals("a LIKE ?", $isNotLike->build());
        self::assertTrue($isNotLike->mustBeConsidered());
        self::assertEquals(["b"], $isNotLike->values());
    }

    public function testNotConfigured()
    {
        $this->expectException(Exception::class);
        $isNotLike = new IsNotLike("a", null);
        $isNotLike->build();
    }

    public function testExpression()
    {
        $isNotLike = new IsNotLike("a", new Expression("NOW()"));
        self::assertEquals("a NOT LIKE NOW()", $isNotLike->build());
        self::assertEquals([], $isNotLike->values());
    }
}
