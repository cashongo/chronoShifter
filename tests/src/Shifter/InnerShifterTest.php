<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\InnerShifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class ShifterShifterTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnValuesFromInnerShifter()
    {
        $shifter = $this->mockShifter();
        $shifter
            ->expects($this->any())
            ->method('shift')
            ->will($this->onConsecutiveCalls('2014-01-01', '2014-01-02', '2014-01-03'));

        $shifterShifter = new InnerShifter($shifter);

        $this->assertEquals('2014-01-01', $shifterShifter->shift('2011-01-01'));
        $this->assertEquals('2014-01-02', $shifterShifter->shift('2011-01-01'));
        $this->assertEquals('2014-01-03', $shifterShifter->shift('2011-01-01'));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockShifter()
    {
        return $this
            ->getMockBuilder('COG\ChronoShifter\Shifter\Shifter')
            ->setMethods(array('shift'))
            ->getMockForAbstractClass();
    }
}
