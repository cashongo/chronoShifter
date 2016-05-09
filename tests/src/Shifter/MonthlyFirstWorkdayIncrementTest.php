<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\HolidayProvider\ArrayHolidayProvider;
use COG\ChronoShifter\Direction\Increasing;
use COG\ChronoShifter\Evaluator\Workday;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\FirstOf;
use COG\ChronoShifter\ChronoShifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class MonthlyFirstWorkdayIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        // Start at one second before first workday of month, shift to next day

        array(
            '2015-05-31 23:59:59', // Starting time
            '2015-06-01', // Expected time
        ),

        // Start at first second of the day after first workday of month, shift forward by a month

        array(
            '2015-06-01', // Starting time
            '2015-07-01', // Expected time
        ),

        array(
            '2015-07-31 15:12:24', // Starting time
            '2015-08-03', // Expected time
        ),

        array(
            '2015-03-01', // Starting time
            '2015-03-04', // Expected time
            [
                '2015-03-02',      // Holidays
                '2015-03-03'
            ]
        ),
        
        array(
            '2015-10-31', // Starting time
            '2015-11-02', // Expected time
            [
                '2015-10-01',      // Holidays
                '2015-10-02'
            ]
        )
    );

    /**
     * @dataProvider shiftProvider
     * @param string $start
     * @param string $expected
     * @param string[] $holidays
     */
    public function testShift($start, $expected, $holidays = array())
    {
        $shifter = new ChronoShifter(new Month($start), new FirstOf(new Increasing(), new Workday(new ArrayHolidayProvider($holidays))));
        $result = $shifter->shift($start);

        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'From %s to next first workday of month ',
                $start
            )
        );
    }

    /**
     * @return array
     */
    public function shiftProvider()
    {
        return $this->fixture;
    }
}
