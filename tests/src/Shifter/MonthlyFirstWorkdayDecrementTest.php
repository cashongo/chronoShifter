<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\ArrayHolidayProvider;
use COG\ChronoShifter\Shifter\MonthlyFirstWorkdayDecrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class MonthlyFirstWorkdayDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        // Start at one second after first workday of month, shift to previous day

        array(
            '2015-06-02 00:00:00', // Starting time
            '2015-06-01 00:00:00', // Expected time
        ),

        // Start at last second of first workday of month, shift back by a month

        array(
            '2015-06-01 00:00:00', // Starting time
            '2015-05-01 00:00:00', // Expected time
        ),

        // Start on day after first workday of month, Monday 3rd

        array(
            '2015-08-04 15:12:24', // Starting time
            '2015-08-03 00:00:00', // Expected time
        ),

        // Start on first workday of month, Monday 3rd

        array(
            '2015-08-03 00:00:00', // Starting time
            '2015-07-01 00:00:00', // Expected time
        ),

        array(
            '2015-04-30 00:00:00', // Starting time
            '2015-04-03 00:00:00', // Expected time
            [
                '2015-04-01',      // Holidays
                '2015-04-02'
            ]
        ),
        
        array(
            '2015-11-30 00:00:00', // Starting time
            '2015-11-04 00:00:00', // Expected time
            [
                '2015-11-02',      // Holidays
                '2015-11-03'
            ]
        )
    );

    /**
     * @dataProvider shiftProvider
     * @param string $start
     * @param string $expected
     * @param string[] $holidays
     */
    public function testShift($start, $expected, $holidays = array())
    {
        $shifter = new MonthlyFirstWorkdayDecrement();
        $shifter->setHolidayProvider(new ArrayHolidayProvider($holidays));

        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
            sprintf(
                'From %s to previous first workday of month ',
                $start
            )
        );
    }

    /**
     * @expectedException \LogicException
     */
    public function testShifterWithoutHolidayProviderThrowsException()
    {
        $shifter = new MonthlyFirstWorkdayDecrement();
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
