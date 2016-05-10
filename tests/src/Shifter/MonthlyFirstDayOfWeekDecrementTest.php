<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Direction\Decreasing;
use COG\ChronoShifter\Evaluator\DayOfWeek;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\FirstOf;
use COG\ChronoShifter\Shifter\ChronoShifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class MonthlyFirstDayOfWeekDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        array(
            3, // Wednesday
            '2015-07-01', // Starting time
            '2015-06-03'  // Expected time
        ),

        array(
            3, // Wednesday
            '2015-07-01 15:12:24', // Starting time
            '2015-06-03'  // Expected time
        ),

        array(
            4, // Thursday
            '2015-07-04 15:12:24', // Starting time
            '2015-07-02'  // Expected time
        ),

        // Day of week is also first day of month

        array(
            7, // Sunday
            '2015-02-15', // Starting time
            '2015-02-01'
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
        $shifter = new ChronoShifter(new Month($start), new FirstOf(new Decreasing(), new DayOfWeek($day)));
        $result = $shifter->shift($start);

        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'From %s to previous first week day of month = %d',
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
