<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\FirstFrom;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class FirstMatchAfterShifterTest extends \PHPUnit_Framework_TestCase
{
    public function testIfMatchKeepDate()
    {
        $evaluator = $this->mockEvaluator();
        $evaluator->expects($this->any())->method('is')->will($this->returnValue(true));
        $firstMatchAfterShifter = new FirstFrom($evaluator);
        $this->assertEquals('2015-02-01', $firstMatchAfterShifter->shift('2015-02-01'));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockShifter()
    {
        return $this
            ->getMockBuilder('COG\ChronoShifter\Shifter\Shifter')
            ->setMethods(array('shift'))
            ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockEvaluator()
    {
        return $this
            ->getMockBuilder('COG\ChronoShifter\Evaluator\Evaluator')
            ->setMethods(array('is'))
            ->getMock();
    }

    public function testIfNotMatchIncrementDate()
    {
        $evaluator = $this->mockEvaluator();
        $evaluator->expects($this->any())->method('is')->will($this->onConsecutiveCalls(false, false, true));
        $firstMatchAfterShifter = new FirstFrom($evaluator);
        $this->assertEquals('2015-02-03', $firstMatchAfterShifter->shift('2015-02-01'));
    }
}
