<?php

namespace rain1\ConditionBuilder;


use rain1\ConditionBuilder\Operator\OperatorInterface;

class ConditionBuilder implements OperatorInterface
{

    const MODE_AND = "AND";
    const MODE_OR = "OR";

    private $mode;

    private $_isNot = false;
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

    public function build():string
    {
        $conditions = [];
        foreach ($this->elements as $element)
            if ($element->isConfigured())
                $conditions[] = $element->build();

        $not = $this->_isNot? "!" : "";

        return "$not(".(implode(" {$this->mode} ", $conditions) ?: $this->getEmptyConditionValue()) .")";
    }

    public function values():array
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

    private function _combine() {
        $string = $this->build();
        $values = $this->values();
        $result = "";
        $count = 0;
        for($i = 0; $i < strlen($string); $i++) {
            if($string[$i] === "?") {
                $result .= json_encode($values[$count]);
                $count++;
            }else{
                $result.=$string[$i];
            }
        }
        return $result;
    }

    public function not()
    {
        $this->_isNot = !$this->_isNot;
        return $this;
    }

    public function configure($conf)
    {

    }

    public function isConfigured()
    {
        return true;
    }

    public function __toString()
    {
        return $this->build();
    }

    public function __invoke()
    {
        return $this->values();
    }

    public function __debugInfo()
    {
        return [
            'condition' => $this->build(),
            'values' => $this->values(),
            'elements' => $this->elements,
            'desired' => $this->_combine()
        ];
    }
}