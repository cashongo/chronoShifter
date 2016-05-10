<?php

namespace Tests\COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\Evaluator\DayOfWeek;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Tests
 */
class DayOfWeekTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dayOfWeekProvider
     * @param string $date
     * @param int $dayOfWeek
     * @param bool $result
     */
    public function testEvaluateDayOfWeek($date, $dayOfWeek, $result)
    {
        $evaluator = new DayOfWeek($dayOfWeek);
        $this->assertEquals($result, $evaluator->is($date));
    }

    /**
     * @return array
     */
    public function dayOfWeekProvider()
    {
        return array(
            array('2015-01-26', DayOfWeek::MONDAY, true),
            array('2015-01-26', DayOfWeek::TUESDAY, false),
            array('2015-01-26', DayOfWeek::WEDNESDAY, false),
            array('2015-01-26', DayOfWeek::THURSDAY, false),
            array('2015-01-26', DayOfWeek::FRIDAY, false),
            array('2015-01-26', DayOfWeek::SATURDAY, false),
            array('2015-01-26', DayOfWeek::SUNDAY, false),

            array('2015-01-27', DayOfWeek::MONDAY, false),
            array('2015-01-27', DayOfWeek::TUESDAY, true),
            array('2015-01-27', DayOfWeek::WEDNESDAY, false),
            array('2015-01-27', DayOfWeek::THURSDAY, false),
            array('2015-01-27', DayOfWeek::FRIDAY, false),
            array('2015-01-27', DayOfWeek::SATURDAY, false),
            array('2015-01-27', DayOfWeek::SUNDAY, false),

            array('2015-01-28', DayOfWeek::MONDAY, false),
            array('2015-01-28', DayOfWeek::TUESDAY, false),
            array('2015-01-28', DayOfWeek::WEDNESDAY, true),
            array('2015-01-28', DayOfWeek::THURSDAY, false),
            array('2015-01-28', DayOfWeek::FRIDAY, false),
            array('2015-01-28', DayOfWeek::SATURDAY, false),
            array('2015-01-28', DayOfWeek::SUNDAY, false),

            array('2015-01-29', DayOfWeek::MONDAY, false),
            array('2015-01-29', DayOfWeek::TUESDAY, false),
            array('2015-01-29', DayOfWeek::WEDNESDAY, false),
            array('2015-01-29', DayOfWeek::THURSDAY, true),
            array('2015-01-29', DayOfWeek::FRIDAY, false),
            array('2015-01-29', DayOfWeek::SATURDAY, false),
            array('2015-01-29', DayOfWeek::SUNDAY, false),

            array('2015-01-30', DayOfWeek::MONDAY, false),
            array('2015-01-30', DayOfWeek::TUESDAY, false),
            array('2015-01-30', DayOfWeek::WEDNESDAY, false),
            array('2015-01-30', DayOfWeek::THURSDAY, false),
            array('2015-01-30', DayOfWeek::FRIDAY, true),
            array('2015-01-30', DayOfWeek::SATURDAY, false),
            array('2015-01-30', DayOfWeek::SUNDAY, false),

            array('2015-01-31', DayOfWeek::MONDAY, false),
            array('2015-01-31', DayOfWeek::TUESDAY, false),
            array('2015-01-31', DayOfWeek::WEDNESDAY, false),
            array('2015-01-31', DayOfWeek::THURSDAY, false),
            array('2015-01-31', DayOfWeek::FRIDAY, false),
            array('2015-01-31', DayOfWeek::SATURDAY, true),
            array('2015-01-31', DayOfWeek::SUNDAY, false),

            array('2015-02-01', DayOfWeek::MONDAY, false),
            array('2015-02-01', DayOfWeek::TUESDAY, false),
            array('2015-02-01', DayOfWeek::WEDNESDAY, false),
            array('2015-02-01', DayOfWeek::THURSDAY, false),
            array('2015-02-01', DayOfWeek::FRIDAY, false),
            array('2015-02-01', DayOfWeek::SATURDAY, false),
            array('2015-02-01', DayOfWeek::SUNDAY, true)
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentWillThrowException()
    {
        new DayOfWeek('1.5');
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testBelowOneDayWillThrowException()
    {
        new DayOfWeek(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testAboveThirtyOneDaysWillThrowException()
    {
        new DayOfWeek(8);
    }
}
