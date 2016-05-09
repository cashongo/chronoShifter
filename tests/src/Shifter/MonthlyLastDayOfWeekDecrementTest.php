<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Direction\Decreasing;
use COG\ChronoShifter\Evaluator\DayOfWeek;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\LastOf;
use COG\ChronoShifter\ChronoShifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class MonthlyLastDayOfWeekDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        array(
            3, // Wednesday
            '2015-07-01', // Starting time
            '2015-06-24'  // Expected time
        ),

        array(
            3, // Wednesday
            '2015-07-01 15:12:24', // Starting time
            '2015-06-24'  // Expected time
        ),

        array(
            4, // Thursday
            '2015-06-25 15:12:24', // Starting time
            '2015-05-28'  // Expected time
        ),

        // Day of week is also last day of month

        array(
            2, // Tuesday
            '2016-06-05', // Starting time
            '2016-05-31'  // Expected time
        )

    );

    /**
     * @dataProvider shiftProvider
     * @param integer $day
     * @param string $start
     * @param string $expected
     */
    public function testShift($day, $start, $expected)
    {
        $shifter = new ChronoShifter(new Month($start), new LastOf(new Decreasing(), new DayOfWeek($day)));
        $result = $shifter->shift($start);

        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'From %s to previous last week day of month = %d',
                $start,
                $day
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
