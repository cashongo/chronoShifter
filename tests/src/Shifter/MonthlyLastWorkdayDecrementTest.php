<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\HolidayProvider\ArrayHolidayProvider;
use COG\ChronoShifter\Direction\Decreasing;
use COG\ChronoShifter\Evaluator\Workday;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\LastOf;
use COG\ChronoShifter\ChronoShifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class MonthlyLastWorkdayDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        // Start at one second after last workday of month, shift to previous day

        array(
            '2015-04-01', // Starting time
            '2015-03-31'  // Expected time
        ),

        // Start at last second of last workday of month, shift back by a month

        array(
            '2015-03-31 23:59:59', // Starting time
            '2015-02-27', // Expected time
        ),

        // Shift over holidays

        array(
            '2015-04-01 15:12:24', // Starting time
            '2015-03-30', // Expected time
            array(
                '2015-03-31'       // Holidays
            )
        ),

        // Start in the middle of a month

        array(
            '2015-06-15', // Starting time
            '2015-05-29'  // Expected time
        ),

        // Start one second before last working day of month
        // Last working day of previous month is a Monday, but it's a holiday
        // Shift over the weekend to Friday of last month

        array(
            '2015-09-29 23:59:59', // Starting time
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
        $shifter = new ChronoShifter(new Month($start), new LastOf(new Decreasing(), new Workday(new ArrayHolidayProvider($holidays))));
        $result = $shifter->shift($start);

        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'From %s to previous last workday of month ',
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
