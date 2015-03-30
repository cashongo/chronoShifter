<?php

namespace Tests\COG\ChronoShifter\ChronoShifter;

use COG\ChronoShifter\ChronoShifter;
use COG\ChronoShifter\Shifter\IsochronicIncrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 */
class ChronoShifterTest extends \PHPUnit_Framework_TestCase
{
    public function testChronoShifterImplementsIterator() {
        $iterator = $this->createIsochronicIncrement();
        $shifter = new ChronoShifter($iterator, new \DateTime('2015-01-03'));

        $this->assertInstanceOf('\Iterator', $shifter);
    }

    public function testShifterIncrementsWithShifter() {
        $iterator = $this->createIsochronicIncrement();

        $shifter = new ChronoShifter($iterator, new \DateTime('2015-01-03'));
        $shifter->next();
        $result = $shifter->current();

        $this->assertEquals('2015-01-15', $result->format('Y-m-d'));
    }

    private function createIsochronicIncrement() {
        return new IsochronicIncrement(
            14,
            new \DateTime('2015-01-01')
        );
    }
}
