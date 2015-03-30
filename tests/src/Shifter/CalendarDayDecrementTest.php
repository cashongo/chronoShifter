<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\CalendarDayDecrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class CalendarDayDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider shiftProvider
     * @param integer $day
     * @param string $start
     * @param string $expected
     */
    public function testShift($day, $start, $expected) {
        $shifter = new CalendarDayDecrement($day);
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
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
    public function shiftProvider() {
        return array(
            /*
             * (1st) From February 1, 2015 to January 1, 2015
             */
            array(
                1,                     // Specific day
                '2015-02-01 00:00:00', // Starting time
                '2015-01-01 00:00:00'  // Expected time
            ),
            /*
             * (1st) From February 1, 2015 to January 1, 2015
             */
            array(
                1,                     // Specific day
                '2014-02-01 15:12:24', // Starting time
                '2014-01-01 00:00:00'  // Expected time
            ),
            /*
             * (14th) From May 15, 2013 to May 14, 2013
             */
            array(
                14,                    // Specific day
                '2014-05-15 00:00:00', // Starting time
                '2014-05-14 00:00:00'  // Expected time
            ),
            /*
             * (31st) From April 1, 2015 to March 31, 2015
             */
            array(
                31,                    // Specific day
                '2015-04-01 00:00:00', // Starting time
                '2015-03-31 00:00:00'  // Expected time
            ),
            /*
            * (31st) From March 1, 2015 to February 28, 2015
            */
            array(
                31,                    // Specific day
                '2015-03-01 00:00:00', // Starting time
                '2015-02-28 00:00:00'  // Expected time
            ),
            /*
             * (31st) From March 1, 2016 to February 29, 2016
             */
            array(
                31,                    // Specific day
                '2016-03-01 00:00:00', // Starting time
                '2016-02-29 00:00:00'  // Expected time
            )
        );
    }

    public function testCastNumericStringToInteger() {
        $shifter = new CalendarDayDecrement('1');
        $this->assertInstanceOf(
            'COG\ChronoShifter\Shifter\CalendarDayDecrement',
            $shifter
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException() {
        new CalendarDayDecrement('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException() {
        new CalendarDayDecrement(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException() {
        new CalendarDayDecrement(32);
    }
}
