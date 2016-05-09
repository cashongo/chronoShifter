<?php

namespace Tests\COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\HolidayProvider\ArrayHolidayProvider;
use COG\ChronoShifter\Evaluator\Workday;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Tests
 */
class WorkdayTest extends \PHPUnit_Framework_TestCase
{
    public function testHolidayAndWeekdayIsNotWorkday()
    {
        $evaluator = new Workday(new ArrayHolidayProvider(array('2010-01-01')));
        $this->assertFalse($evaluator->is('2010-01-01'));
    }

    public function testHolidayAndWeekendIsNotWorkday()
    {
        $evaluator = new Workday(new ArrayHolidayProvider(array('2010-01-03')));
        $this->assertFalse($evaluator->is('2010-01-03'));
    }

    public function testNonHolidayAndWeekdayIsWorkday()
    {
        $evaluator = new Workday(new ArrayHolidayProvider(array('2010-01-03')));
        $this->assertTrue($evaluator->is('2010-01-01'));
    }

    public function testNonHolidayAndWeekendIsNotWorkday()
    {
        $evaluator = new Workday(new ArrayHolidayProvider(array('2010-01-01')));
        $this->assertFalse($evaluator->is('2010-01-03'));
    }
}
