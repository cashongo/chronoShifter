<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\DayOfMonthDecrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class DayOfMonthDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(
        array(
            1, // Specific day
            '2015-02-01', // Starting time
            '2015-01-01'  // Expected time
        ),
        array(
            1, // Specific day
            '2014-02-01 15:12:24', // Starting time
            '2014-01-01'  // Expected time
        ),
        array(
            14, // Specific day
            '2014-05-15', // Starting time
            '2014-05-14'  // Expected time
        ),
        array(
            31, // Specific day
            '2015-04-01', // Starting time
            '2015-03-31'  // Expected time
        ),
        array(
            31, // Specific day
            '2015-03-01', // Starting time
            '2015-02-28'  // Expected time
        ),
        array(
            31, // Specific day
            '2016-03-01', // Starting time
            '2016-02-29'  // Expected time
        ),
        array(
            31, // Specific day
            '2016-01-01', // Starting time
            '2015-12-31'  // Expected time
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
        $shifter = new DayOfMonthDecrement($day);
        $result = $shifter->shift($start);
        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'From %s to previous day of month = %d',
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
        $shifter = new DayOfMonthDecrement('1');
        $this->assertInstanceOf(
            'COG\ChronoShifter\Shifter\DayOfMonthDecrement',
            $shifter
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException()
    {
        new DayOfMonthDecrement('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException()
    {
        new DayOfMonthDecrement(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException()
    {
        new DayOfMonthDecrement(32);
    }
}
