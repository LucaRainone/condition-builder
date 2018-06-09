<?php

namespace rain1\ConditionBuilder\Operator;

class IsNull extends AbstractOperator
{

    private $field;
    private $_isConfigured;

    public function __construct($field, bool $condition = true)
    {
        $this->field = $field;
        $this->_isConfigured = $condition;
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

    public function isConfigured()
    {
        return $this->_isConfigured;
    }
}