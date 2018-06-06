<?php

namespace rain1\ConditionBuilder\Operator;

class IsLike extends AbstractLeftRightOperator
{
    protected $operator = "LIKE";

    public function build():String {
        $this->operator = $this->isNot? "NOT LIKE" : "LIKE";
        return parent::build();
    }
}