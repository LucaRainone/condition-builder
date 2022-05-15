<?php

namespace rain1\ConditionBuilder\Operator;

use rain1\ConditionBuilder\Expression\ExpressionInterface;

class IsEqual extends AbstractOperator
{
    /**
     * @var mixed
     */
    private $leftOperand;
    /**
     * @var mixed
     */
    private $rightOperand;

    public function __construct($leftOperand, $rightOperand)
    {
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
    }

    public function build(): String
    {
        parent::build();

        $placeholder = $this->getConfiguration()->getPlaceholder();

        if (is_array($this->rightOperand)) {
            $condition = $this->_buildInOperatorCondition($this->leftOperand, $this->rightOperand, $placeholder);
        } else {
            $condition = $this->_buildEqualOperatorCondition($this->leftOperand, $this->rightOperand, $placeholder);
        }
        return $condition;
    }

    private function _buildInOperatorCondition(string $left, array $right, string $placeholder): string
    {
        if (empty($right)) {
            return "FALSE";
        }

        $operator = $this->isNot ? "NOT IN" : "IN";
        return "$left $operator (" .
            $this->_commaSeparatedPlaceholder(count($right), $placeholder) .
            ")";
    }

    private function _buildEqualOperatorCondition(string $left, $right, string $placeholder): string
    {
        $operator = $this->isNot ? "!=" : "=";
        $right = $right instanceof ExpressionInterface ? $right->__toString() : $placeholder;
        return "$left $operator $right";
    }

    private function _commaSeparatedPlaceholder(int $count, string $placeholder): string
    {
        return implode(",", array_fill(0, $count, $placeholder));
    }

    public function mustBeConsidered(): bool
    {
        return !is_null($this->rightOperand);
    }

    public function values(): array
    {
        if ($this->rightOperand instanceof ExpressionInterface) {
            return [];
        }

        return is_array($this->rightOperand) ? $this->rightOperand : [$this->rightOperand];
    }
}
