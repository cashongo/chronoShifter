<?php
namespace {
    require_once 'LogicalEvaluatorTest.php';
}

namespace Tests\COG\ChronoShifter\Evaluator {
    use COG\ChronoShifter\Evaluator\LogicalNot;

    /**
     * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
     * @package Evaluator\Tests
     */
    class LogicalNotTest extends LogicalEvaluatorTest
    {
        public function testFailIfEvaluatorReturnsTrue()
        {
            $mock = $this->createMock();
            $this->mockReturns($mock, true);
            $evaluator = new LogicalNot($mock);

            $this->assertFalse($evaluator->is('2014-01-01'));
        }

        public function testPassIfEvaluatorReturnsFalse()
        {
            $mock = $this->createMock();
            $this->mockReturns($mock, false);
            $evaluator = new LogicalNot($mock);

            $this->assertTrue($evaluator->is('2014-01-01'));
        }
    }
}