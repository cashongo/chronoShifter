<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\FirstMatchBefore;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class FirstMatchBeforeTest extends \PHPUnit_Framework_TestCase
{
    public function testIfMatchKeepDate()
    {
        $shifter = $this->mockShifter();
        $shifter->expects($this->any())->method('shift')->will($this->returnValue('2015-02-01'));

        $evaluator = $this->mockEvaluator();
        $evaluator->expects($this->any())->method('is')->will($this->returnValue(true));

        $firstMatchBeforeShifter = new FirstMatchBefore($shifter, $evaluator);

        $this->assertEquals('2015-02-01', $firstMatchBeforeShifter->shift('2011-01-01'));
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
        $shifter = $this->mockShifter();
        $shifter->expects($this->any())->method('shift')->will($this->returnValue('2015-02-01'));

        $evaluator = $this->mockEvaluator();
        $evaluator->expects($this->any())->method('is')->will($this->onConsecutiveCalls(false, false, true));

        $firstMatchBeforeShifter = new FirstMatchBefore($shifter, $evaluator);

        $this->assertEquals('2015-01-30', $firstMatchBeforeShifter->shift('2011-01-01'));
    }
}
