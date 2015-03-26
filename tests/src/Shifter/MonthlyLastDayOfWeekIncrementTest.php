<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekIncrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class MonthlyLastDayOfWeekIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider shiftProvider
     * @param integer $day
     * @param string $start
     * @param string $expected
     */
    public function testShift($day, $start, $expected) {
        $shifter = new MonthlyLastDayOfWeekIncrement($day);
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
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
    public function shiftProvider() {
        return array(
            /*
             * (MON) From June 2, 2015 to June 22, 2015
             */
            array(
                1,                     // Specific day
                '2015-06-02 00:00:00', // Starting time
                '2015-06-29 00:00:00'  // Expected time
            ),
            /*
             * (MON) From June 2, 2015 to June 22, 2015
             */
            array(
                1,                     // Specific day
                '2015-06-02 15:12:24', // Starting time
                '2015-06-29 00:00:00'  // Expected time
            ),
            /*
             * (SUN) From June 29, 2015 to July 26, 2015
             */
            array(
                7,                     // Specific day
                '2015-06-29 15:12:24', // Starting time
                '2015-07-26 00:00:00'  // Expected time
            ),
            /*
             * (FRI) From June 2, 2015 to June 26, 2015
             */
            array(
                5,                     // Specific day
                '2015-06-15 00:00:00', // Starting time
                '2015-06-26 00:00:00'  // Expected time
            )
        );
    }

    public function testCastNumericStringToInteger() {
        $shifter = new MonthlyLastDayOfWeekIncrement('1');
        $this->assertInstanceOf(
            'COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekIncrement',
            $shifter
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException() {
        new MonthlyLastDayOfWeekIncrement('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException() {
        new MonthlyLastDayOfWeekIncrement(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException() {
        new MonthlyLastDayOfWeekIncrement(8);
    }
}
