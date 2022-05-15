<?php

namespace rain1\ConditionBuilder\Expression\MySQL\Date;

use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Expression\ExpressionInterface;

class Date implements ExpressionInterface
{
    private $date;

    public static function now()
    {
        return new Expression("NOW()");
    }

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function __toString()
    {
        return "'" . date("Y-m-d", $this->_unixTimestamp($this->date)) . "'";
    }

    private function _unixTimestamp($date)
    {
        return is_int($date) ? $date : ($date instanceof Expression ? $date : strtotime($date));
    }
}
