<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\IsochronicIncrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class IsochronicIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        // Shift up by four weeks
        array(
            '2015-06-02 00:00:00', // Day of reference
            '2015-06-02 00:00:00', // Starting time
            '2015-06-30 00:00:00'  // Expected time
        ),

        // Discard time of the day
        array(
            '2015-06-02 00:00:00', // Day of reference
            '2015-06-02 15:12:24', // Starting time
            '2015-06-30 00:00:00'  // Expected time
        ),

        // Reference date in past
        array(
            '2015-06-10 15:12:24', // Day of reference
            '2015-06-29 00:00:00', // Starting time
            '2015-07-08 00:00:00'  // Expected time
        ),

        // Reference date in future
        array(
            '2015-07-01 00:00:00', // Day of reference
            '2015-06-15 00:00:00', // Starting time
            '2015-07-01 00:00:00'  // Expected time
        ),

        // Reference date on the next day
        array(
            '2015-07-02 00:00:00', // Day of reference
            '2015-06-15 00:00:00', // Starting time
            '2015-07-02 00:00:00'  // Expected time
        ),

        // February with 28 days
        array(
            '2015-02-01 00:00:00', // Day of reference
            '2015-02-15 00:00:00', // Starting time
            '2015-03-01 00:00:00'  // Expected time
        ),

        // February with 29 days
        array(
            '2016-02-01 00:00:00', // Day of reference
            '2016-02-15 00:00:00', // Starting time
            '2016-02-29 00:00:00'  // Expected time
        ),
        // Increment with DST difference
        array(
            '2015-04-05 10:26:20', // Day of reference
            '2015-03-04 00:00:00', // Starting time
            '2015-03-08 00:00:00'  // Expected time
        ),
        // Increment with DST difference
        array(
            '2015-04-05 10:26:20', // Day of reference
            '2015-10-15 00:00:00', // Starting time
            '2015-10-18 00:00:00'  // Expected time
        )
    );

    /**
     * @dataProvider shiftProvider
     * @param integer $reference
     * @param string $start
     * @param string $expected
     */
    public function testShift($reference, $start, $expected)
    {
        $shifter = new IsochronicIncrement(28, new \DateTime($reference));
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
            sprintf(
                'From %s to next four weeks referencing %s',
                $start,
                $reference
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
