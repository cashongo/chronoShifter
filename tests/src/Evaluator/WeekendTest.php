<?php

namespace Tests\COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\Evaluator\DayOfWeek;
use COG\ChronoShifter\Evaluator\Weekend;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Tests
 */
class WeekendTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider weekendProvider
     * @param string $date
     * @param int $dayOfWeek
     * @param bool $result
     */
    public function testEvaluateDayOfWeek($date, $dayOfWeek, $result)
    {
        $evaluator = new Weekend($dayOfWeek);
        $this->assertEquals($result, $evaluator->is($date));
    }

    /**
     * @return array
     */
    public function weekendProvider()
    {
        return array(
            array('2015-01-26', DayOfWeek::MONDAY, false),
            array('2015-01-27', DayOfWeek::TUESDAY, false),
            array('2015-01-28', DayOfWeek::WEDNESDAY, false),
            array('2015-01-29', DayOfWeek::THURSDAY, false),
            array('2015-01-30', DayOfWeek::FRIDAY, false),
            array('2015-01-31', DayOfWeek::SATURDAY, true),
            array('2015-02-01', DayOfWeek::SUNDAY, true),
        );
    }
}
