<?php

namespace rain1\ConditionBuilder\Operator;

use rain1\ConditionBuilder\Configuration\ConfigurationInterface;

interface OperatorInterface
{
    public function build(): String;
    public function values(): array;
    public function not();
    public function setConfiguration(ConfigurationInterface $conf): OperatorInterface;
    public function mustBeConsidered();
}
