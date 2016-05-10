<?php

namespace Tests\COG\ChronoShifter\Selector;

use COG\ChronoShifter\Direction\Decreasing;
use COG\ChronoShifter\Direction\Direction;
use COG\ChronoShifter\Direction\Increasing;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\Specific;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Selector\Test
 */
class SpecificTest extends \PHPUnit_Framework_TestCase
{
    public function testIfUpcomingMatchFoundUseCurrentPeriod()
    {
        $selector = new Specific(new Increasing(), 15);

        $date = '2014-02-05';
        $period = new Month($date);
        $this->assertEquals('2014-02-15', $selector->select($date, $period));
    }

    public function testIfNoUpcomingMatchFoundUseNextPeriod()
    {
        $selector = new Specific(new Increasing(), 15);

        $date = '2014-02-25';
        $period = new Month($date);
        $this->assertEquals('2014-03-15', $selector->select($date, $period));
    }

    public function testIfNoUpcomingMatchFoundUsePreviousPeriod()
    {
        $selector = new Specific(new Decreasing(), 15);

        $date = '2014-02-05';
        $period = new Month($date);
        $this->assertEquals('2014-01-15', $selector->select($date, $period));
    }

    public function testCapNumberToDaysInPeriod()
    {
        $selector = new Specific(new Increasing(), 31);
        
        $date = '2015-02-01';
        $period = new Month($date);
        $this->assertEquals('2015-02-28', $selector->select($date, $period));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @uses COG\ChronoShifter\Direction\Direction
     */
    public function testInvalidArgumentWillThrowException()
    {
        new Specific($this->getMockForAbstractClass('COG\ChronoShifter\Direction\Direction'), '1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     * @uses COG\ChronoShifter\Direction\Direction
     */
    public function testBelowOneDayWillThrowException()
    {
        new Specific($this->getMockForAbstractClass('COG\ChronoShifter\Direction\Direction'), 0);
    }
}
