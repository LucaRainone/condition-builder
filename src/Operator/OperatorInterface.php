<?php

namespace rain1\ConditionBuilder\Operator;


use rain1\ConditionBuilder\Configuration\Configuration;

interface OperatorInterface
{
    public function build():String;
    public function values():array;
    public function not();
    public function setConfiguration(Configuration $conf):OperatorInterface;
    public function isConfigured();
}