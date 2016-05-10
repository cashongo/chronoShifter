<?php

namespace Tests\COG\ChronoShifter\Date;

use COG\ChronoShifter\HolidayProvider\ArrayHolidayProvider;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package HolidayProvider\Test
 */
class ArrayHolidayProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testIfInArrayThenIsHoliday()
    {
        $arrayHolidayProvider = new ArrayHolidayProvider(['2015-01-01']);
        $this->assertTrue($arrayHolidayProvider->isHoliday('2015-01-01'));
    }

    public function testIgnoreTime()
    {
        $arrayHolidayProvider = new ArrayHolidayProvider(['2015-01-01']);
        $this->assertTrue($arrayHolidayProvider->isHoliday('2015-01-01 12:15:00'));
    }

    public function testIfNotInArrayThenNotAHoliday()
    {
        $arrayHolidayProvider = new ArrayHolidayProvider(['2015-01-01']);
        $this->assertFalse($arrayHolidayProvider->isHoliday('2015-01-02'));
    }
}
