<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekDecrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class MonthlyLastDayOfWeekDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider shiftProvider
     * @param integer $day
     * @param string $start
     * @param string $expected
     */
    public function testShift($day, $start, $expected) {
        $shifter = new MonthlyLastDayOfWeekDecrement($day);
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
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
    public function shiftProvider() {
        return array(
            array(
                3,                     // Specific day
                '2015-07-01 00:00:00', // Starting time
                '2015-06-24 00:00:00'  // Expected time
            ),
            array(
                3,                     // Specific day
                '2015-07-01 15:12:24', // Starting time
                '2015-06-24 00:00:00'  // Expected time
            ),
            array(
                4,                     // Specific day
                '2015-06-25 15:12:24', // Starting time
                '2015-05-28 00:00:00'  // Expected time
            )
        );
    }

    public function testCastNumericStringToInteger() {
        $shifter = new MonthlyLastDayOfWeekDecrement('1');
        $this->assertInstanceOf(
            'COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekDecrement',
            $shifter
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException() {
        new MonthlyLastDayOfWeekDecrement('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException() {
        new MonthlyLastDayOfWeekDecrement(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException() {
        new MonthlyLastDayOfWeekDecrement(8);
    }
}
