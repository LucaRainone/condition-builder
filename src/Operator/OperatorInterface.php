<?php

namespace rain1\ConditionBuilder\Operator;

use rain1\ConditionBuilder\Configuration\ConfigurationInterface;

interface OperatorInterface
{
    public function build(): String;
    public function values(): array;
    public function not(): OperatorInterface;
    public function setConfiguration(ConfigurationInterface $configuration): OperatorInterface;
    public function mustBeConsidered(): bool;
}
