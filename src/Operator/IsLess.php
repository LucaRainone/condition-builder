<?php

namespace rain1\ConditionBuilder\Operator;

class IsLess extends IsGreaterOrEqual
{
    protected $isNot = true;
}