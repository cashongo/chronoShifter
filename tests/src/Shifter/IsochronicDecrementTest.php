<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\IsochronicDecrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class IsochronicDecrementTest extends \PHPUnit_Framework_TestCase
{
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
        return array(
            /*
             * Shift down by four weeks
             *
             * (2015-07-01) From July 1, 2015 to June 3, 2015
             */
            array(
                '2015-07-01 00:00:00', // Day of reference
                '2015-07-01 00:00:00', // Starting time
                '2015-06-03 00:00:00'  // Expected time
            ),
            /*
             * Discard time of the day
             *
             * (2015-07-01) From July 1, 2015 to June 3, 2015
             */
            array(
                '2015-07-01 00:00:00', // Day of reference
                '2015-07-01 15:12:24', // Starting time
                '2015-06-03 00:00:00'  // Expected time
            ),
            /*
             * Reference date in future
             *
             * (2015-07-02) From July 1, 2015 to June 4, 2015
             */
            array(
                '2015-07-02 00:00:00', // Day of reference
                '2015-07-01 00:00:00', // Starting time
                '2015-06-04 00:00:00'  // Expected time
            ),
            /*
             * Reference date on the previous day
             *
             * (2015-06-30) From July 1, 2015 to June 30, 2015
             */
            array(
                '2015-06-30 00:00:00', // Day of reference
                '2015-07-01 00:00:00', // Starting time
                '2015-06-30 00:00:00'  // Expected time
            ),
            /*
             * Reference date on the next day
             *
             * (2015-06-10) From June 25, 2015 to May 29, 2015
             */
            array(
                '2015-06-26 15:12:24', // Day of reference
                '2015-06-25 00:00:00', // Starting time
                '2015-05-29 00:00:00'  // Expected time
            ),
            /*
             * February with 28 days
             *
             * (2015-03-21) From March 28, 2015 to February 28, 2015
             */
            array(
                '2015-03-28 00:00:00', // Day of reference
                '2015-03-15 00:00:00', // Starting time
                '2015-02-28 00:00:00'  // Expected time
            ),
            /*
             * February with 29 days
             *
             * (2016-03-21) From March 28, 2015 to February 28, 2015
             */
            array(
                '2016-03-28 00:00:00', // Day of reference
                '2016-03-15 00:00:00', // Starting time
                '2016-02-29 00:00:00'  // Expected time
            )
        );
    }
}