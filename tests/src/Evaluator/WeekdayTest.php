<?php

namespace Tests\COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\Evaluator\DayOfWeek;
use COG\ChronoShifter\Evaluator\Weekday;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Tests
 */
class WeekdayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider weekdayProvider
     * @param string $date
     * @param int $dayOfWeek
     * @param bool $result
     */
    public function testEvaluateDayOfWeek($date, $dayOfWeek, $result)
    {
        $evaluator = new Weekday($dayOfWeek);
        $this->assertEquals($result, $evaluator->is($date));
    }

    /**
     * @return array
     */
    public function weekdayProvider()
    {
        return array(
            array('2015-01-26', DayOfWeek::MONDAY, true),
            array('2015-01-27', DayOfWeek::TUESDAY, true),
            array('2015-01-28', DayOfWeek::WEDNESDAY, true),
            array('2015-01-29', DayOfWeek::THURSDAY, true),
            array('2015-01-30', DayOfWeek::FRIDAY, true),
            array('2015-01-31', DayOfWeek::SATURDAY, false),
            array('2015-02-01', DayOfWeek::SUNDAY, false),
        );
    }
}
