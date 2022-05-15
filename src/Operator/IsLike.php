<?php

namespace rain1\ConditionBuilder\Operator;

class IsLike extends AbstractLeftRightOperator
{
    protected string $operator = "LIKE";

    public function build(): string
    {
        $this->operator = $this->isNot ? "NOT LIKE" : "LIKE";
        return parent::build();
    }
}
