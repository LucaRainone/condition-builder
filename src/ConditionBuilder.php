<?php

namespace rain1\ConditionBuilder;


use rain1\ConditionBuilder\Configuration\Configuration;
use rain1\ConditionBuilder\Operator\OperatorInterface;

class ConditionBuilder implements OperatorInterface
{

    const MODE_AND = "AND";
    const MODE_OR = "OR";

    private $mode;
    private $_conf;

    private $_isNot = false;

    private $_resultsOnEmpty;
    /**
     * @var OperatorInterface[]
     */
    private $elements = [];

    public function __construct($mode, Configuration $configuration = null)
    {
        $this->mode = $mode;
        $this->_conf = $configuration ?: new Configuration();
        $this->setResultOnEmpty($this->mode === self::MODE_AND? "TRUE" : "FALSE");
    }

    public function setResultOnEmpty(string $result)
    {
        $this->_resultsOnEmpty = $result;
    }

    public function append(OperatorInterface ... $elements): self
    {

        foreach ($elements as $element)
            $this->elements[] = $element->setConfiguration($this->_conf);

        return $this;
    }

    public function build(): string
    {
        $conditions = [];
        foreach ($this->elements as $element)
            if ($element->isConfigured())
                $conditions[] = $element->build();

        $not = $this->_isNot ? "!" : "";

        return "$not(" . (implode(" {$this->mode} ", $conditions) ?: $this->getEmptyConditionValue()) . ")";
    }

    public function values(): array
    {
        $values = [];
        foreach ($this->elements as $element)
            if ($element->isConfigured())
                $values = array_merge($values, $element->values());

        return $values;
    }

    private function getEmptyConditionValue()
    {
        return $this->_resultsOnEmpty;
    }

    private function _combine()
    {
        $string = $this->build();
        $values = $this->values();
        $result = "";
        $count = 0;
        $placeholder = $this->_conf->getPlaceholder();
        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === $placeholder) {
                $result .= json_encode($values[$count]);
                $count++;
            } else {
                $result .= $string[$i];
            }
        }
        return $result;
    }

    public function not()
    {
        $this->_isNot = !$this->_isNot;
        return $this;
    }

    public function setConfiguration(Configuration $conf): OperatorInterface
    {
        $this->_conf = $conf;
        return $this;
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