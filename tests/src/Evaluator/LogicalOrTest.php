<?php
namespace {
    require_once 'LogicalEvaluatorTest.php';
}

namespace Tests\COG\ChronoShifter\Evaluator {

    use COG\ChronoShifter\Evaluator\Evaluator;
    use COG\ChronoShifter\Evaluator\LogicalOr;

    /**
     * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
     * @package Evaluator\Tests
     */
    class LogicalOrTest extends LogicalEvaluatorTest
    {
        /**
         * @var Evaluator
         */
        protected $firstMock;

        /**
         * @var Evaluator
         */
        protected $secondMock;

        /**
         * @uses Evaluator
         */
        public function setUp()
        {
            $this->firstMock = $this->createMock();
            $this->secondMock = $this->createMock();
        }

        /**
         * @dataProvider logicalOrProvider
         * @param bool $result
         * @param bool $left
         * @param bool $right
         */
        public function testLogicalAndIsTrueIfBothSidesAreTrue($result, $left, $right)
        {
            $this->mockReturns($this->firstMock, $left);
            $this->mockReturns($this->secondMock, $right);

            $evaluator = new LogicalOr($this->firstMock, $this->secondMock);
            $this->assertEquals($result, $evaluator->is('2014-01-01'));
        }

        public function logicalOrProvider()
        {
            return array(
                array(true, true, true),
                array(true, true, false),
                array(false, false, false),
                array(true, false, true)
            );
        }
    }
}