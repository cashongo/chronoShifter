<?php

namespace Tests\COG\ChronoShifter\ChronoIterator;

use COG\ChronoShifter\ChronoShifter;
use COG\ChronoShifter\Direction\Increasing;
use COG\ChronoShifter\Period\IsoChronic;
use COG\ChronoShifter\Selector\Specific;
use COG\ChronoShifter\ChronoIterator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Test
 */
class ChronoShifterTest extends \PHPUnit_Framework_TestCase
{
    public function testChronoShifterImplementsIterator()
    {
        $shifter = $this->createIsoChronicIncrement();
        $iterator = new ChronoIterator($shifter, '2015-01-03');

        $this->assertInstanceOf('\Iterator', $iterator);
    }

    public function testShifterBeginsFromFirstMatch()
    {
        $shifter = $this->createIsoChronicIncrement();

        $iterator = new ChronoIterator($shifter, '2015-01-03');
        $result = $iterator->current();

        $this->assertEquals('2015-01-15', $result);
    }

    public function testShifterIncrementsWithShifter()
    {
        $shifter = $this->createIsoChronicIncrement();

        $iterator = new ChronoIterator($shifter, '2015-01-03');
        $iterator->next();
        $result = $iterator->current();

        $this->assertEquals('2015-01-29', $result);
    }

    public function testShifterKeyIsTimestamp()
    {
        $shifter = $this->createIsoChronicIncrement();

        $iterator = new ChronoIterator($shifter, '2015-01-03');
        $iterator->next();

        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $date->setDate(2015, 01, 15)->setTime(0, 0, 0);

        $this->assertInternalType('integer', $iterator->key());
    }

    public function testShifterPositionValidForOldDates()
    {
        $shifter = $this->createIsoChronicIncrement();
        $iterator = new ChronoIterator($shifter, '1988-09-01');

        $this->assertTrue($iterator->valid());
    }

    public function testShifterPositionValidForFutureDates()
    {
        $shifter = $this->createIsoChronicIncrement();
        $iterator = new ChronoIterator($shifter, '2100-09-01');

        $this->assertTrue($iterator->valid());
    }

    /**
     * @return ChronoShifter
     */
    private function createIsoChronicIncrement()
    {
        return new ChronoShifter(new Isochronic('2015-01-01', '2015-01-01', 14), new Specific(new Increasing(), 1));
    }
}
