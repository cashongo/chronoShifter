<?php
namespace {
    require_once 'LogicalEvaluatorTest.php';
}

namespace Tests\COG\ChronoShifter\Evaluator {

    use COG\ChronoShifter\Evaluator\Evaluator;
    use COG\ChronoShifter\Evaluator\LogicalAnd;

    /**
     * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
     * @package Evaluator\Tests
     */
    class LogicalAndTest extends LogicalEvaluatorTest
    {
        /**
         * @var Evaluator
         */
        private $firstMock;

        /**
         * @var Evaluator
         */
        private $secondMock;

        /**
         * @uses Evaluator
         */
        public function setUp()
        {
            $this->firstMock = $this->createMock();
            $this->secondMock = $this->createMock();
        }

        /**
         * @dataProvider logicalAndProvider
         * @param bool $result
         * @param bool $left
         * @param bool $right
         */
        public function testLogicalAndIsTrueIfBothSidesAreTrue($result, $left, $right)
        {
            $this->mockReturns($this->firstMock, $left);
            $this->mockReturns($this->secondMock, $right);

            $evaluator = new LogicalAnd($this->firstMock, $this->secondMock);
            $this->assertEquals($result, $evaluator->is('2014-01-01'));
        }

        public function logicalAndProvider()
        {
            return array(
                array(true, true, true),
                array(false, true, false),
                array(false, false, false),
                array(false, false, true)
            );
        }
    }
}