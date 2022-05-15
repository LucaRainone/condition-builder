<?php

namespace rain1\ConditionBuilder\Operator;

use rain1\ConditionBuilder\Configuration\Configuration;
use rain1\ConditionBuilder\Configuration\ConfigurationInterface;
use rain1\ConditionBuilder\Expression\ExpressionInterface;

abstract class AbstractOperator implements OperatorInterface
{
    protected $isNot = false;
    protected $_conf;

    public function not()
    {
        $this->isNot = !$this->isNot;
        return $this;
    }

    public function setConfiguration(ConfigurationInterface $configuration): OperatorInterface
    {
        $this->_conf = $configuration;
        return $this;
    }

    /**
     * @return String
     * @throws Exception
     */
    public function build(): String
    {
        if (!$this->mustBeConsidered()) {
            throw new Exception("Operator::build must be called only if at least one operator is set");
        }

        return "";
    }

    protected function fetchPlaceholderOrExpressionString($value)
    {
        return $value instanceof ExpressionInterface ? $value->__toString() : $this->getConfiguration()->getPlaceholder();
    }

    protected function getConfiguration(): Configuration
    {
        if (!$this->_conf) {
            $this->_conf = new Configuration();
        }
        return $this->_conf;
    }
}
