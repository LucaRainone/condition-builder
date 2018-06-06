<?php

namespace raind1;

use rain1\ConditionBuilder\ConditionBuilder;
use rain1\ConditionBuilder\Operator\IsEqual;
use rain1\ConditionBuilder\Operator\IsLess;
use rain1\ConditionBuilder\Operator\IsNotEqual;

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('rain1\\ConditionBuilder\\', __DIR__);

$condition = new ConditionBuilder("and");

$condition
    ->append(new IsEqual("field_1",1))
    ->append(new IsEqual("field_2", null))
    ->append(new IsEqual("field_3", [1, 2, 3]))
    ->append((new IsEqual("field_4", 1))->not())
    ->append((new IsEqual("field_5", [1, 2, 3]))->not())
    ->append((new IsNotEqual("field_6", 1)))
    ->append((new IsLess("field_6", 1)))
    ;



echo $condition->build();

print_r($condition->values());