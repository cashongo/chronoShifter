<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\ArrayHolidayProvider;
use COG\ChronoShifter\Shifter\FirstWorkingDayBeforeDecorator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class FirstWorkingDayBeforeDecoratorTest extends \PHPUnit_Framework_TestCase
{
    public function testKeepDateIfWorkingDay()
    {
        $shifter = $this->getMockForShifterReturningDate('2015-10-19 00:00:00');

        $decorator = new FirstWorkingDayBeforeDecorator($shifter, new ArrayHolidayProvider(array()));
        $result = $decorator->shift(new \DateTime());

        $this->assertEquals('2015-10-19', $result->format('Y-m-d'));
    }

    public function testDecrementDateIfWeekend()
    {
        $shifter = $this->getMockForShifterReturningDate('2015-10-18 00:00:00');

        $decorator = new FirstWorkingDayBeforeDecorator($shifter, new ArrayHolidayProvider(array()));
        $result = $decorator->shift(new \DateTime());

        $this->assertEquals('2015-10-16', $result->format('Y-m-d'));
    }

    public function testDecrementDateIfHoliday()
    {
        $shifter = $this->getMockForShifterReturningDate('2015-10-18 00:00:00');

        $decorator = new FirstWorkingDayBeforeDecorator($shifter, new ArrayHolidayProvider(array('2015-10-16')));
        $result = $decorator->shift(new \DateTime());

        $this->assertEquals('2015-10-15', $result->format('Y-m-d'));
    }

    /**
     * @param string $date
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockForShifterReturningDate($date)
    {
        $shifter = $this->getMockBuilder('COG\ChronoShifter\Shifter\Shifter')
            ->setMethods(array('shift'))
            ->getMock();

        $shifter
            ->expects($this->once())
            ->method('shift')
            ->will($this->returnValue(new \DateTime($date)));

        return $shifter;
    }
}