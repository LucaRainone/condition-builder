<?php

namespace rain1\ConditionBuilder\Operator;

use rain1\ConditionBuilder\ConditionBuilder;
use rain1\ConditionBuilder\Expression\ExpressionInterface;

/**
 * @rain\ConditionBuilder\ConditionBuilder(method="isBetween")
 */
class IsBetween extends AbstractOperator
{
    /**
     * @var mixed
     */
    private $field;
    /**
     * @var mixed
     */
    private $start;
    /**
     * @var mixed
     */
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

        return !is_null($this->start) && !is_null($this->end) ? $this->_buildFull() : $this->_buildWithOneLimit();
    }

    private function _buildFull(): string
    {
        $operator = $this->isNot ? "NOT BETWEEN" : "BETWEEN";

        $firstCustomOperand = $this->fetchPlaceholderOrExpressionString($this->start);
        $secondCustomOperand = $this->fetchPlaceholderOrExpressionString($this->end);

        return "{$this->field} $operator {$firstCustomOperand} AND {$secondCustomOperand}";
    }

    private function _buildWithOneLimit(): string
    {
        if (is_null($this->end)) {
            $operator = $this->isNot ? "<" : ">=";
            $operand = $this->fetchPlaceholderOrExpressionString($this->start);
        } elseif (is_null($this->start)) {
            $operator = $this->isNot ? ">" : "<=";
            $operand = $this->fetchPlaceholderOrExpressionString($this->end);
        }

        return "{$this->field} $operator {$operand}";
    }

    public function values(): array
    {
        return array_values(
            array_filter([$this->start, $this->end], function ($el) {
                return !is_null($el) && !($el instanceof ExpressionInterface);
            })
        );
    }

    public function mustBeConsidered(): bool
    {
        return !is_null($this->start) || !is_null($this->end);
    }
}
