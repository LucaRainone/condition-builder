<?php

namespace rain1\ConditionBuilder\Operator;

class IsNull extends AbstractOperator
{

    private $field;
    private $_mustBeConsidered;

    public function __construct($field, bool $mustBeConsidered = true)
    {
        $this->field = $field;
        $this->_mustBeConsidered = $mustBeConsidered;
    }

    public function build(): String
    {

        parent::build();

        $operator = $this->isNot? "IS NOT NULL" : "IS NULL";

        return "{$this->field} $operator";
    }

    public function values():array
    {
        return [];
    }

    public function mustBeConsidered()
    {
        return $this->_mustBeConsidered;
    }
}