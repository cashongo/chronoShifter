<?php

namespace Tests\COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\Evaluator\Evaluator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Tests
 */
abstract class LogicalEvaluatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Evaluator
     */
    protected function createMock()
    {
        return $this
            ->getMockBuilder('COG\ChronoShifter\Evaluator\Evaluator')
            ->setMethods(array('is'))
            ->getMockForAbstractClass();
    }

    /**
     * @param \PHPUnit_Framework_MockObject_MockObject $mock
     * @param bool $value
     */
    protected function mockReturns($mock, $value)
    {
        $mock
            ->expects($this->any())
            ->method('is')
            ->will($this->returnValue($value));
    }
}
