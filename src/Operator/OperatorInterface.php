<?php

namespace rain1\ConditionBuilder\Operator;


interface OperatorInterface
{
    public function build():String;
    public function values():array;
    public function not();
    public function configure($conf);
    public function isConfigured();
}