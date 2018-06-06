<?php

namespace rain1\ConditionBuilder;


use rain1\ConditionBuilder\Operator\OperatorInterface;

class ConditionBuilder
{

    const MODE_AND = "AND";
    const MODE_OR = "OR";

    private $mode;
    /**
     * @var OperatorInterface[]
     */
    private $elements = [];

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function append(OperatorInterface $element)
    {
        $args = func_get_args();

        foreach ($args as $arg)
            $this->elements[] = $arg;

        return $this;
    }

    public function build()
    {
        $conditions = [];
        foreach ($this->elements as $element)
            if ($element->isConfigured())
                $conditions[] = $element->build();

        return "(".(implode(" {$this->mode} ", $conditions) ?: $this->getEmptyConditionValue()) .")";
    }

    public function values()
    {
        $values = [];
        foreach ($this->elements as $element)
            if ($element->isConfigured())
                $values = array_merge($values, $element->values());

        return $values;
    }

    private function getEmptyConditionValue()
    {
        return $this->mode === self::MODE_AND ? "TRUE" : "FALSE";
    }
}