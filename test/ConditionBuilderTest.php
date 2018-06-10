<?php

namespace rain1\ConditionBuilder\test;

use PHPUnit\Framework\TestCase;
use rain1\ConditionBuilder\ConditionBuilder;
use rain1\ConditionBuilder\Configuration\Configuration;
use rain1\ConditionBuilder\Operator\OperatorInterface;

class ConditionBuilderTest extends TestCase
{

    public function testEmpty()
    {
        $conditionBuilder = self::getInstanceModeAnd();
        self::assertEquals("(TRUE)", $conditionBuilder->build(), "Empty condition in AND must print (TRUE)");

        $conditionBuilder = self::getInstanceModeOr();
        self::assertEquals("(FALSE)", $conditionBuilder->build(), "Empty condition in OR must print (FALSE)");
    }

    public function testDummyOperator()
    {
        $conditionBuilder = self::getInstanceModeAnd();

        $conditionBuilder->append(new DummyOperator(true));

        self::assertEquals($conditionBuilder->build(), "(a DUMMY_OP b)");
        self::assertEquals($conditionBuilder->values(), [1, 2, 3]);
    }

    public function testDummyOperatorConcatAND()
    {
        $conditionBuilder = self::getInstanceModeAnd();

        $conditionBuilder
            ->append(new DummyOperator(true))
            ->append(new DummyOperator(true));

        self::assertEquals($conditionBuilder->build(), "(a DUMMY_OP b AND a DUMMY_OP b)");
        self::assertEquals($conditionBuilder->values(), [1, 2, 3, 1, 2, 3]);
    }

    public function testDummyOperatorConcatOR()
    {
        $conditionBuilder = self::getInstanceModeOr();

        $conditionBuilder
            ->append(new DummyOperator(true))
            ->append(new DummyOperator(true));

        self::assertEquals($conditionBuilder->build(), "(a DUMMY_OP b OR a DUMMY_OP b)");
        self::assertEquals($conditionBuilder->values(), [1, 2, 3, 1, 2, 3]);
    }

    public function testMultipleArgumentAppend()
    {
        $conditionBuilder = self::getInstanceModeAnd();

        $conditionBuilder
            ->append(new DummyOperator(true), new DummyOperator(true));

        self::assertEquals($conditionBuilder->build(), "(a DUMMY_OP b AND a DUMMY_OP b)");
        self::assertEquals($conditionBuilder->values(), [1, 2, 3, 1, 2, 3]);
    }

    public function testIgnoreNotConfiguredOperator()
    {
        $conditionBuilder = self::getInstanceModeAnd();

        $conditionBuilder
            ->append(new DummyOperator(true), new DummyOperator(false));

        self::assertEquals($conditionBuilder->build(), "(a DUMMY_OP b)");
        self::assertEquals($conditionBuilder->values(), [1, 2, 3]);
    }

    public function testNot() {
        $conditionBuilder = self::getInstanceModeAnd();
        $conditionBuilder->append(new DummyOperator());
        self::assertInstanceOf(ConditionBuilder::class, $conditionBuilder->not());
        self::assertEquals("!(a DUMMY_OP b)",$conditionBuilder->build());
    }

    private static function getInstanceModeAnd()
    {
        return new ConditionBuilder(ConditionBuilder::MODE_AND);
    }

    private static function getInstanceModeOr()
    {
        return new ConditionBuilder(ConditionBuilder::MODE_OR);
    }

}

class DummyOperator implements OperatorInterface
{

    protected $_mustBeConsidered;
    protected $_conf;


    public function __construct($mustBeConsidered = true, Configuration $conf = null)
    {
        $this->_mustBeConsidered = $mustBeConsidered;
        $this->_conf = $conf?:new Configuration();
    }

    public function setConfiguration(Configuration $conf):OperatorInterface
    {
        return $this;
    }

    public function build(): String
    {
        return "a DUMMY_OP b";
    }

    public function values():array
    {
        return [1, 2, 3];
    }

    public function not()
    {

    }

    public function mustBeConsidered()
    {
        return $this->_mustBeConsidered;
    }

}