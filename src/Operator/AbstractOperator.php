<?php

namespace rain1\ConditionBuilder\Operator;


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

}