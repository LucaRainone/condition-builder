<?php

namespace rain1\ConditionBuilder\Operator;


use rain1\ConditionBuilder\Expression\ExpressionInterface;

abstract class AbstractOperator implements OperatorInterface
{

    protected $isNot = false;
    protected $valuePlaceholder = "?";

    public function not() {
        $this->isNot = !$this->isNot;
        return $this;
    }

    public function configureValuePlaceholder($placeholder) {
        $this->valuePlaceholder = $placeholder;
    }

    public function build():String {

        if(!$this->isConfigured())
            throw new Exception("Operator::build must be called only if operator is configured");

        return "";
    }

    protected function fetchPlaceholderOrExpressionString($value) {
        return $value instanceof ExpressionInterface? $value->__toString() : $this->valuePlaceholder;
    }

}