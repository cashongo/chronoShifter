<?php

namespace Tests\COG\ChronoShifter\Date;

use COG\ChronoShifter\Date\Date;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class DateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \LogicException
     */
    public function testCheckHolidayWithoutProviderThrowsLogicException() {
        $date = new Date(new \DateTime());
        $date->isHoliday();
    }

    public function testDateWithoutHolidayProviderDefaultsToNull() {
        $date = new Date(new \DateTime());
        $this->assertEquals(null, $date->getHolidayProvider());
    }

    public function testDateWithHolidayProviderCanAccessHolidayProvider() {
        $holidayProvider = $this
            ->getMockBuilder('COG\ChronoShifter\Date\HolidayProvider')
            ->setMethods(array('isHoliday'))
            ->getMockForAbstractClass();
        $date = new Date(new \DateTime());
        $date->setHolidayProvider($holidayProvider);
        $this->assertEquals($holidayProvider, $date->getHolidayProvider());
    }
}