<?php

namespace rain1\ConditionBuilder\Operator;

use rain1\ConditionBuilder\Expression\ExpressionInterface;

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

        parent::build();

        if (is_array($this->rightOperand)) {
            $operator = $this->isNot ? "NOT IN" : "IN";
            $condition = "{$this->leftOperand} $operator (" . implode(",", array_fill(0, count($this->rightOperand), $this->valuePlaceholder)) . ")";
        } else {
            $operator = $this->isNot ? "!=" : "=";

            $rightOperand = $this->rightOperand instanceof ExpressionInterface?
                $this->rightOperand->__toString() : $this->valuePlaceholder;

            $condition = "{$this->leftOperand} $operator {$rightOperand}";
        }
        return $condition;
    }

    public function isConfigured()
    {
        if(is_array($this->rightOperand))
            return !empty($this->rightOperand);

        return !is_null($this->rightOperand);
    }

    public function values()
    {

        if($this->rightOperand instanceof ExpressionInterface)
            return [];

        return is_array($this->rightOperand) ? $this->rightOperand : [$this->rightOperand];

    }
}