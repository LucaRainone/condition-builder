<?php

namespace rain1\ConditionBuilder\Operator;

class IsGreaterOrEqual extends AbstractLeftRightOperator
{
    protected $operator = ">=";

    public function build(): String
    {
        $this->operator = $this->isNot ? "<" : ">=";
        return parent::build();
    }
}
