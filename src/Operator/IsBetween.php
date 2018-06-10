<?php

namespace rain1\ConditionBuilder\Operator;

use rain1\ConditionBuilder\Expression\ExpressionInterface;

class IsBetween extends AbstractOperator
{

    private $field;
    private $start;
    private $end;

    public function __construct($field, $start, $end)
    {
        $this->field = $field;
        $this->start = $start;
        $this->end = $end;
    }

    public function build(): String
    {

        parent::build();

        return !is_null($this->start) && !is_null($this->end)? $this->_buildFull() : $this->_buildWithOneLimit();
    }

    private function _buildFull() {
        $operator = $this->isNot ? "NOT BETWEEN" : "BETWEEN";

        $firstCustomOperand = $this->fetchPlaceholderOrExpressionString($this->start);
        $secondCustomOperand = $this->fetchPlaceholderOrExpressionString($this->end);

        return "{$this->field} $operator {$firstCustomOperand} AND {$secondCustomOperand}";
    }

    private function _buildWithOneLimit() {

        if (is_null($this->end)) {
            $operator = $this->isNot ? "<" : ">=";
            $operand = $this->fetchPlaceholderOrExpressionString($this->start);
        }
        else if (is_null($this->start)) {
            $operator = $this->isNot ? ">" : "<=";
            $operand = $this->fetchPlaceholderOrExpressionString($this->end);
        } else
            throw new Exception("all operators are null");

        return "{$this->field} $operator {$operand}";
    }

    public function values():array
    {
        return array_values(
            array_filter([$this->start, $this->end], function ($el) {
                return !is_null($el) && !($el instanceof ExpressionInterface);
            })
        );
    }

    public function isConfigured()
    {
        return !is_null($this->start) || !is_null($this->end);
    }
}