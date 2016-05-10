<?php

namespace Tests\COG\ChronoShifter\Selector;

use COG\ChronoShifter\HolidayProvider\ArrayHolidayProvider;
use COG\ChronoShifter\Direction\Decreasing;
use COG\ChronoShifter\Direction\Increasing;
use COG\ChronoShifter\Evaluator\Holiday;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\LastOf;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Selector\Test
 */
class LastOfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $holidays = array(
        '2014-01-05',
        '2014-01-15',
        '2014-01-25',
        '2014-02-05',
        '2014-02-15',
        '2014-02-25',
        '2014-03-05',
        '2014-03-15',
        '2014-03-25'
    );

    /**
     * @var ArrayHolidayProvider
     */
    private $holidayProvider;

    public function setUp()
    {
        $this->holidayProvider = new ArrayHolidayProvider($this->holidays);
    }

    public function testIfUpcomingMatchFoundUseCurrentPeriod()
    {
        $selector = new LastOf(new Increasing(), new Holiday($this->holidayProvider));

        $date = '2014-02-01';
        $period = new Month($date);
        $this->assertEquals('2014-02-25', $selector->select($date, $period));
    }

    public function testIfNoUpcomingMatchFoundUseNextPeriod()
    {
        $selector = new LastOf(new Increasing(), new Holiday($this->holidayProvider));

        $date = '2014-02-25';
        $period = new Month($date);
        $this->assertEquals('2014-03-25', $selector->select($date, $period));
    }

    public function testIfNoUpcomingMatchFoundUsePreviousPeriod()
    {
        $selector = new LastOf(new Decreasing(), new Holiday($this->holidayProvider));

        $date = '2014-02-25';
        $period = new Month($date);
        $this->assertEquals('2014-01-25', $selector->select($date, $period));
    }
}
