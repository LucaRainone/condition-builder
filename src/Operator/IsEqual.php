<?php

namespace rain1\ConditionBuilder\Operator;

class IsEqual extends AbstractOperator
{
    private $leftOperand;
    private $rightOperand;

    public function __construct($leftOperand, $rightOperand)
    {
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
    }

    public function build():String
    {

        if (is_array($this->rightOperand)) {
            $operator = $this->isNot ? "NOT IN" : "IN";
            $condition = "{$this->leftOperand} $operator (" . implode(",", array_fill(0, count($this->rightOperand), $this->valuePlaceholder)) . ")";
        } else {
            $operator = $this->isNot ? "!=" : "=";
            $condition = "{$this->leftOperand} $operator {$this->valuePlaceholder}";
        }
        return $condition;
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