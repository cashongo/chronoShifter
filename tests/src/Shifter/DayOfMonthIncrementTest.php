<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Direction\Increasing;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\Specific;
use COG\ChronoShifter\Shifter\ChronoShifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class DayOfMonthIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(
        array(
            1, // Specific day
            '2015-01-01', // Starting time
            '2015-02-01'  // Expected time
        ),
        array(
            1, // Specific day
            '2014-01-01 15:12:24', // Starting time
            '2014-02-01'  // Expected time
        ),
        array(
            15, // Specific day
            '2014-04-14', // Starting time
            '2014-04-15'  // Expected time
        ),
        array(
            31, // Specific day
            '2015-03-01', // Starting time
            '2015-03-31'  // Expected time
        ),
        array(
            31, // Specific day
            '2015-02-01', // Starting time
            '2015-02-28'  // Expected time
        ),
        array(
            31, // Specific day
            '2016-02-01', // Starting time
            '2016-02-29'  // Expected time
        ),
        array(
            31, // Specific day
            '2016-08-31', // Starting time
            '2016-09-30'  // Expected time
        ),
        array(
            31, // Specific day
            '2016-12-31', // Starting time
            '2017-01-31'
        )
    );

    /**
     * @dataProvider shiftProvider
     * @param integer $day
     * @param string $start
     * @param string $expected
     */
    public function testShift($day, $start, $expected)
    {
        $shifter = new ChronoShifter(new Month($start), new Specific(new Increasing(), $day));
        $result = $shifter->shift($start);

        $this->assertEquals(
            $expected,
            $result,
            sprintf(
                'From %s to next day of month = %d',
                $start,
                $day
            )
        );
    }

    /**
     * @return array
     */
    public function shiftProvider()
    {
        return $this->fixture;
    }
}
