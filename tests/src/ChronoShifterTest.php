<?php

namespace Tests\COG\ChronoShifter\ChronoShifter;

use COG\ChronoShifter\ChronoShifter;
use COG\ChronoShifter\Shifter\IsochronicIncrement;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Test
 */
class ChronoShifterTest extends \PHPUnit_Framework_TestCase
{
    public function testChronoShifterImplementsIterator()
    {
        $iterator = $this->createIsochronicIncrement();
        $shifter = new ChronoShifter($iterator, '2015-01-03');

        $this->assertInstanceOf('\Iterator', $shifter);
    }

    public function testShifterBeginsFromFirstMatch()
    {
        $iterator = $this->createIsochronicIncrement();

        $shifter = new ChronoShifter($iterator, '2015-01-03');
        $result = $shifter->current();

        $this->assertEquals('2015-01-15', $result);
    }

    public function testShifterIncrementsWithShifter()
    {
        $iterator = $this->createIsochronicIncrement();

        $shifter = new ChronoShifter($iterator, '2015-01-03');
        $shifter->next();
        $result = $shifter->current();

        $this->assertEquals('2015-01-29', $result);
    }

    public function testShifterKeyIsTimestamp()
    {
        $iterator = $this->createIsochronicIncrement();

        $shifter = new ChronoShifter($iterator, '2015-01-03');
        $shifter->next();

        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $date->setDate(2015, 01, 15)->setTime(0, 0, 0);

        $this->assertInternalType('integer', $shifter->key());
    }

    public function testShifterPositionValidForOldDates()
    {
        $iterator = $this->createIsochronicIncrement();

        $shifter = new ChronoShifter($iterator, '1988-09-01');
        $this->assertTrue($shifter->valid());
    }

    public function testShifterPositionValidForFutureDates()
    {
        $iterator = $this->createIsochronicIncrement();

        $shifter = new ChronoShifter($iterator, '2100-09-01');
        $this->assertTrue($shifter->valid());
    }

    /**
     * @return IsochronicIncrement
     */
    private function createIsochronicIncrement()
    {
        return new IsochronicIncrement(14, '2015-01-01');
    }
}
