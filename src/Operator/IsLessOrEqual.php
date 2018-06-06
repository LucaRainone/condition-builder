<?php

namespace rain1\ConditionBuilder\Operator;

class IsLessOrEqual extends AbstractLeftRightOperator
{
    protected $operator = "<=";

    public function build():String {
        $this->operator = $this->isNot? ">" : "<=";
        return parent::build();
    }
}