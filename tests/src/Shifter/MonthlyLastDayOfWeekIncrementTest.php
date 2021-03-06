<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Direction\Increasing;
use COG\ChronoShifter\Evaluator\DayOfWeek;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\LastOf;
use COG\ChronoShifter\Shifter\ChronoShifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class MonthlyLastDayOfWeekIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        array(
            1, // Monday
            '2015-06-02', // Starting time
            '2015-06-29'  // Expected time
        ),

        array(
            1, // Monday
            '2015-06-02 15:12:24', // Starting time
            '2015-06-29'  // Expected time
        ),

        array(
            7, // Sunday
            '2015-06-29 15:12:24', // Starting time
            '2015-07-26'  // Expected time
        ),

        array(
            5, // Friday
            '2015-06-15', // Starting time
            '2015-06-26'  // Expected time
        ),

        // Day of week is also last day of month

        array(
            2, // Tuesday
            '2016-05-06', // Starting time
            '2016-05-31'
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
        $shifter = new ChronoShifter(new Month($start), new LastOf(new Increasing(), new DayOfWeek($day)));
        $result = $shifter->shift($start);

        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'From %s to next last week day of month = %d',
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
