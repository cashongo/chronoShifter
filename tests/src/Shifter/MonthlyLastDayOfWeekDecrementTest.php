<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekDecrement;

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
        $shifter = new MonthlyLastDayOfWeekDecrement($day);
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

    public function testCastNumericStringToInteger()
    {
        $shifter = new MonthlyLastDayOfWeekDecrement('1');
        $this->assertInstanceOf(
            'COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekDecrement',
            $shifter
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException()
    {
        new MonthlyLastDayOfWeekDecrement('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException()
    {
        new MonthlyLastDayOfWeekDecrement(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException()
    {
        new MonthlyLastDayOfWeekDecrement(8);
    }
}
