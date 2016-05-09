<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\HolidayProvider\ArrayHolidayProvider;
use COG\ChronoShifter\Direction\Increasing;
use COG\ChronoShifter\Evaluator\Workday;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\LastOf;
use COG\ChronoShifter\ChronoShifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class MonthlyLastWorkdayIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        // Start at one second before last workday of month, shift to next day

        array(
            '2015-03-30 23:59:59', // Starting time
            '2015-03-31'  // Expected time
        ),

        // Start at first second of the day after last workday of month, shift forward by a month

        array(
            '2015-03-31 23:59:59', // Starting time
            '2015-04-30', // Expected time
        ),

        // Shift over holidays

        array(
            '2015-03-30 15:12:24', // Starting time
            '2015-04-30', // Expected time
            array(
                '2015-03-31'       // Holidays
            )
        ),

        // Start in the middle of a month

        array(
            '2015-06-15', // Starting time
            '2015-06-30'  // Expected time
        ),

        // Start at first second of last working day of month
        // Last working day of next month is a Monday, but it's a holiday
        // Shift over the weekend to Friday of the next month

        array(
            '2015-07-31', // Starting time
            '2015-08-28', // Expected time
            array(
                '2015-08-31'       // Holidays
            )
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
        $shifter = new ChronoShifter(new Month($start), new LastOf(new Increasing(), new Workday(new ArrayHolidayProvider($holidays))));
        $result = $shifter->shift($start);

        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'From %s to next last workday of month ',
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
