<?php

namespace rain1\ConditionBuilder\Operator;


interface OperatorInterface
{
    public function build():String;
    public function values();
    public function not();
    public function isConfigured();
}