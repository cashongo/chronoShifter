<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\CalendarDayIncrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class CalendarDayIncrementTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider shiftProvider
     * @param integer $day
     * @param string $start
     * @param string $expected
     */
    public function testShift($day, $start, $expected) {
        $shifter = new CalendarDayIncrement($day);
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
            sprintf(
                'From %s to next day of month = %d',
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
             * (1) From January 1, 2015 to February 1, 2015
             */
          array(
            1,                     // Specific day
            '2015-01-01 00:00:00', // Starting time
            '2015-02-01 00:00:00'  // Expected time
          ),
            /*
             * (1) From January 1, 2015 to February 1, 2015
             */
          array(
            1,                     // Specific day
            '2014-01-01 15:12:24', // Starting time
            '2014-02-01 00:00:00'  // Expected time
          ),
            /*
             * (15) From April 14, 2013 to April 15, 2013
             */
          array(
            15,                    // Specific day
            '2014-04-14 00:00:00', // Starting time
            '2014-04-15 00:00:00'  // Expected time
          ),
            /*
             * (31) From March 1, 2015 to March 31, 2015
             */
          array(
            31,                    // Specific day
            '2015-03-01 00:00:00', // Starting time
            '2015-03-31 00:00:00'  // Expected time
          ),
            /*
            * (31) From February 1, 2015 to February 28, 2015
            */
          array(
            31,                    // Specific day
            '2015-02-01 00:00:00', // Starting time
            '2015-02-28 00:00:00'  // Expected time
          ),
            /*
             * (31) From February 1, 2016 to February 29, 2016
             */
          array(
            31,                    // Specific day
            '2016-02-01 00:00:00', // Starting time
            '2016-02-29 00:00:00'  // Expected time
          )
        );
    }

    public function testCastNumericStringToInteger() {
        $shifter = new CalendarDayIncrement('1');
        $this->assertInstanceOf(
          'COG\ChronoShifter\Shifter\CalendarDayIncrement',
          $shifter
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException() {
        new CalendarDayIncrement('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException() {
        new CalendarDayIncrement(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException() {
        new CalendarDayIncrement(32);
    }
}