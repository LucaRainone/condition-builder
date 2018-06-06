<?php

namespace rain1\ConditionBuilder\Operator;

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

        if (!is_null($this->start) && !is_null($this->end)) {
            $operator = $this->isNot ? "IS NOT BETWEEN" : "IS BETWEEN";
            return "{$this->field} $operator ? AND ?";
        } else if (is_null($this->end))
            $operator = $this->isNot ? "<" : ">=";
        else if (is_null($this->start))
            $operator = $this->isNot ? ">" : "<=";
        else
            throw new Exception("IsBetween seems not to be configured");

        return "{$this->field} $operator ?";
    }

    public function values()
    {
        return array_values(
            array_filter([$this->start, $this->end], function ($el) {
                return !is_null($el);
            })
        );
    }

    public function isConfigured()
    {
        return !is_null($this->start) || !is_null($this->end);
    }
}