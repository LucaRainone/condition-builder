<?php

namespace rain1\ConditionBuilder\Operator;

abstract class AbstractOperator implements OperatorInterface
{

    protected $isNot = false;
    protected $valuePlaceholder = "?";
    protected $operator;
    public function not() {
        $this->isNot = true;
        return $this;
    }

    public function configureValuePlaceholder($placeholder) {
        $this->valuePlaceholder = $placeholder;
    }

}