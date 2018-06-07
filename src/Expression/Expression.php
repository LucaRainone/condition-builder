<?php

namespace rain1\ConditionBuilder\Expression;

class Expression implements ExpressionInterface
{

    private $expression;

    public function __construct(string $expression)
    {
        $this->expression = $expression;
    }

    public function __toString(): string
    {
        return $this->expression;
    }
}