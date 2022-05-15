<?php

namespace rain1\ConditionBuilder\Expression\MySQL\Date;

use rain1\ConditionBuilder\Expression\ExpressionInterface;

class DateAdd implements ExpressionInterface
{
    public const UNIT_SECOND = "SECOND";
    public const UNIT_MINUTE = "MINUTE";
    public const UNIT_HOUR = "HOUR";
    public const UNIT_DAY = "DAY";
    public const UNIT_MONTH = "MONTH";
    public const UNIT_YEAR = "YEAR";


    private $date;
    private $adding;
    private $unit;

    public function __construct($date, $adding, $unit)
    {
        $this->date = $date;
        $this->adding = $adding;
        $this->unit = $unit;
    }

    public function __toString()
    {
        return "DATE_ADD(\"{$this->date}\", INTERVAL {$this->adding} {$this->unit})";
    }
}
