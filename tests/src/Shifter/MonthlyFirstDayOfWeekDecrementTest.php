<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekDecrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class MonthlyFirstDayOfWeekDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider shiftProvider
     * @param integer $day
     * @param string $start
     * @param string $expected
     */
    public function testShift($day, $start, $expected) {
        $shifter = new MonthlyFirstDayOfWeekDecrement($day);
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
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
    public function shiftProvider() {
        return array(
            /*
             * (WED) From July 1, 2015 to June 3, 2015
             */
            array(
                3,                     // Specific day
                '2015-07-01 00:00:00', // Starting time
                '2015-06-03 00:00:00'  // Expected time
            ),
            /*
             * (WED) From July 1, 2015 to June 3, 2015
             */
            array(
                3,                     // Specific day
                '2015-07-01 15:12:24', // Starting time
                '2015-06-03 00:00:00'  // Expected time
            ),
            /*
             * (THU) From July 4, 2015 to July 2, 2015
             */
            array(
                4,                     // Specific day
                '2015-07-04 15:12:24', // Starting time
                '2015-07-02 00:00:00'  // Expected time
            )
        );
    }

    public function testCastNumericStringToInteger() {
        $shifter = new MonthlyFirstDayOfWeekDecrement('1');
        $this->assertInstanceOf(
            'COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekDecrement',
            $shifter
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException() {
        new MonthlyFirstDayOfWeekDecrement('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException() {
        new MonthlyFirstDayOfWeekDecrement(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException() {
        new MonthlyFirstDayOfWeekDecrement(8);
    }
}