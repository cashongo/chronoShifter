<?php

namespace Tests\COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Shifter\IsochronicIncrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Tests\COG\ChronoShifter
 * @subpackage Shifter
 */
class IsochronicIncrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider shiftProvider
     * @param integer $reference
     * @param string $start
     * @param string $expected
     */
    public function testShift($reference, $start, $expected) {
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
    public function shiftProvider() {
        return array(
            /*
             * Shift up by four weeks
             *
             * (2015-06-02) From June 2, 2015 to June 30, 2015
             */
            array(
                '2015-06-02 00:00:00', // Day of reference
                '2015-06-02 00:00:00', // Starting time
                '2015-06-30 00:00:00'  // Expected time
            ),
            /*
             * Discard time of the day
             *
             * (2015-06-02) From June 2, 2015 to June 30, 2015
             */
            array(
                '2015-06-02 00:00:00', // Day of reference
                '2015-06-02 15:12:24', // Starting time
                '2015-06-30 00:00:00'  // Expected time
            ),
            /*
             * Reference date in past
             *
             * (2015-06-10) From June 29, 2015 to July 27, 2015
             */
            array(
                '2015-06-10 15:12:24', // Day of reference
                '2015-06-29 00:00:00', // Starting time
                '2015-07-08 00:00:00'  // Expected time
            ),
            /*
             * Reference date in future
             *
             * (2015-07-01) From June 2, 2015 to July 13, 2015
             */
            array(
                '2015-07-01 00:00:00', // Day of reference
                '2015-06-15 00:00:00', // Starting time
                '2015-07-01 00:00:00'  // Expected time
            ),
            /*
             * Reference date on the next day
             *
             * (2015-07-01) From June 2, 2015 to July 13, 2015
             */
            array(
                '2015-07-02 00:00:00', // Day of reference
                '2015-06-15 00:00:00', // Starting time
                '2015-07-02 00:00:00'  // Expected time
            ),
            /*
             * February with 28 days
             *
             * (2015-02-01) From February 15, 2016 to March 1, 2016
             */
            array(
                '2015-02-01 00:00:00', // Day of reference
                '2015-02-15 00:00:00', // Starting time
                '2015-03-01 00:00:00'  // Expected time
            ),

            /*
             * February with 29 days
             *
             * (2016-02-01) From February 15, 2016 to February 29, 2016
             */
            array(
                '2016-02-01 00:00:00', // Day of reference
                '2016-02-15 00:00:00', // Starting time
                '2016-02-29 00:00:00'  // Expected time
            ),
            /*
             * Increment with DST difference
             */
            array(
                '2015-04-05 10:26:20', // Day of reference
                '2015-03-04 00:00:00', // Starting time
                '2015-03-08 00:00:00'  // Expected time
            ),
            /*
             * Increment with DST difference
             */
            array(
                '2015-04-05 10:26:20', // Day of reference
                '2015-10-15 00:00:00', // Starting time
                '2015-10-18 00:00:00'  // Expected time
            )
        );
    }
}
