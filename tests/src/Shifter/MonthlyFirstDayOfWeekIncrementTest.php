<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekIncrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class MonthlyFirstDayOfWeekIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider shiftProvider
     * @param integer $day
     * @param string $start
     * @param string $expected
     */
    public function testShift($day, $start, $expected) {
        $shifter = new MonthlyFirstDayOfWeekIncrement($day);
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
            sprintf(
                'From %s to next first week day of month = %d',
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
             * (MON) From June 2, 2015 to July 6, 2015
             */
            array(
                1,                     // Specific day
                '2015-06-02 00:00:00', // Starting time
                '2015-07-06 00:00:00'  // Expected time
            ),
            /*
             * (MON) From June 2, 2015 to July 6, 2015
             */
            array(
                1,                     // Specific day
                '2015-06-02 15:12:24', // Starting time
                '2015-07-06 00:00:00'  // Expected time
            ),
            /*
             * (SUN) From June 2, 2015 to July 6, 2015
             */
            array(
                7,                     // Specific day
                '2015-06-02 15:12:24', // Starting time
                '2015-06-07 00:00:00'  // Expected time
            ),
            /*
             * (FRI) From June 15, 2015 to July 3, 2015
             */
            array(
                5,                     // Specific day
                '2015-06-15 00:00:00', // Starting time
                '2015-07-03 00:00:00'  // Expected time
            )
        );
    }

    public function testCastNumericStringToInteger() {
        $shifter = new MonthlyFirstDayOfWeekIncrement('1');
        $this->assertInstanceOf(
            'COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekIncrement',
            $shifter
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException() {
        new MonthlyFirstDayOfWeekIncrement('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException() {
        new MonthlyFirstDayOfWeekIncrement(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException() {
        new MonthlyFirstDayOfWeekIncrement(8);
    }
}
