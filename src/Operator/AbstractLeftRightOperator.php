<?php

namespace rain1\ConditionBuilder\Operator;

abstract class AbstractLeftRightOperator extends AbstractOperator {

    protected $leftOperand;
    protected $rightOperand;
    protected $operator;

    public function __construct($left, $right)
    {
        $this->leftOperand = $left;
        $this->rightOperand = $right;
    }

    public function build():String
    {
        parent::build();
        return "{$this->leftOperand} {$this->operator} {$this->valuePlaceholder}";
    }

    public function isConfigured()
    {
        return !is_null($this->rightOperand);
    }

    public function values()
    {
        return is_array($this->rightOperand) ? $this->rightOperand : [$this->rightOperand];
    }

}