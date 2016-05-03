<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\MonthlyFirstWorkdayIncrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class MonthlyFirstWeekdayIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(
        array(
            '2015-06-02 00:00:00', // Starting time
            '2015-06-03 00:00:00'  // Expected time
        ),
        array(
            '2015-06-03 15:12:24', // Starting time
            '2015-07-01 00:00:00'  // Expected time
        ),
        array(
            '2014-02-02 15:12:24', // Starting time
            '2014-02-05 00:00:00'  // Expected time
        ),
        array(
            '2015-03-01 00:00:00', // Starting time
            '2015-03-04 00:00:00'  // Expected time
        ),
        array(
            '2015-10-31 00:00:00', // Starting time
            '2015-11-02 00:00:00'  // Expected time
        )
    );

    /**
     * @dataProvider shiftProvider
     * @param string $start
     * @param string $expected
     */
    public function testShift($start, $expected)
    {
        $holidayProvider = $this
            ->getMockBuilder('COG\ChronoShifter\Date\HolidayProvider')
            ->setMethods(array('isHoliday'))
            ->getMockForAbstractClass();

        $holidayProvider->expects($this->any())
            ->method('isHoliday')
            ->willReturnOnConsecutiveCalls(
                true,
                true,
                false
            );

        $shifter = new MonthlyFirstWorkdayIncrement();
        $shifter->setHolidayProvider($holidayProvider);
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
            sprintf(
                'From %s to next first weekday of month ',
                $start
            )
        );
    }

    /**
     * @expectedException \LogicException
     */
    public function testShifterWithoutHolidayProviderThrowsException()
    {
        $shifter = new MonthlyFirstWorkdayIncrement();
        $shifter->shift(new \DateTime('2015-01-01'));
    }

    /**
     * @return array
     */
    public function shiftProvider()
    {
        return $this->fixture;
    }
}
