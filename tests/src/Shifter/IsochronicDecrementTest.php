<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\IsochronicDecrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Test
 */
class IsochronicDecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixture = array(

        // Shift down by four weeks
        array(
            '2015-07-01 00:00:00', // Day of reference
            '2015-07-01 00:00:00', // Starting time
            '2015-06-03 00:00:00'  // Expected time
        ),

        // Discard time of the day
        array(
            '2015-07-01 00:00:00', // Day of reference
            '2015-07-01 15:12:24', // Starting time
            '2015-06-03 00:00:00'  // Expected time
        ),

        // Reference date in future
        array(
            '2015-07-02 00:00:00', // Day of reference
            '2015-07-01 00:00:00', // Starting time
            '2015-06-04 00:00:00'  // Expected time
        ),

        // Reference date on the previous day
        array(
            '2015-06-30 00:00:00', // Day of reference
            '2015-07-01 00:00:00', // Starting time
            '2015-06-30 00:00:00'  // Expected time
        ),

        // Reference date on the next day
        array(
            '2015-06-26 15:12:24', // Day of reference
            '2015-06-25 00:00:00', // Starting time
            '2015-05-29 00:00:00'  // Expected time
        ),

        // February with 28 days
        array(
            '2015-03-28 00:00:00', // Day of reference
            '2015-03-15 00:00:00', // Starting time
            '2015-02-28 00:00:00'  // Expected time
        ),

        // February with 29 days
        array(
            '2016-03-28 00:00:00', // Day of reference
            '2016-03-15 00:00:00', // Starting time
            '2016-02-29 00:00:00'  // Expected time
        ),

        // Decrement with DST difference
        array(
            '2015-04-05 10:26:20', // Day of reference
            '2015-04-01 00:00:00', // Starting time
            '2015-03-08 00:00:00'  // Expected time
        ),

        // Decrement with DST difference
        array(
            '2015-04-05 10:26:20', // Day of reference
            '2015-11-12 00:00:00', // Starting time
            '2015-10-18 00:00:00'  // Expected time
        )
    );

    /**
     * @dataProvider shiftProvider
     * @param integer $reference
     * @param string $start
     * @param string $expected
     */
    public function testShiftDown($reference, $start, $expected) {
        $shifter = new IsochronicDecrement(28, new \DateTime($reference));
        $date = new \DateTime($start);
        $shifter->shift($date);

        $this->assertEquals(
            $expected,
            $date->format('Y-m-d H:i:s'),
            sprintf(
                'From %s to previous four weeks referencing %s',
                $start,
                $reference
            )
        );
    }

    /**
     * @return array
     */
    public function shiftProvider() {
        return $this->fixture;
    }
}
