<?php

namespace rain1\ConditionBuilder\Operator;

use rain1\ConditionBuilder\Expression\ExpressionInterface;

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

        $operand = $this->fetchPlaceholderOrExpressionString($this->rightOperand);

        return "{$this->leftOperand} {$this->operator} {$operand}";
    }

    public function mustBeConsidered()
    {
        return !is_null($this->rightOperand);
    }

    public function values():array
    {
        return $this->rightOperand instanceof ExpressionInterface? [] : [$this->rightOperand];
    }

}