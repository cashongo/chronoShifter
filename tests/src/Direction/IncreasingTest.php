<?php

namespace Tests\COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\Direction\Increasing;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Direction\Tests
 */
class IncrementTest extends \PHPUnit_Framework_TestCase
{
    public function testNextMovesToNextPeriod()
    {
        $periodMock = $this
            ->getMockBuilder('COG\ChronoShifter\Period\Period')
            ->setMethods(array('next'))
            ->getMockForAbstractClass();

        $periodMock->expects($this->once())->method('next');

        $direction = new Increasing();
        $direction->next($periodMock);
    }

    public function testCompareEqualDates()
    {
        $direction = new Increasing();
        $this->assertEquals(0, $direction->compare('2014-01-01 00:23:23', '2014-01-01 00:25:25'));
    }

    public function testFirstDateAfterSecondDate()
    {
        $direction = new Increasing();
        $this->assertEquals(1, $direction->compare('2014-01-02 00:00:00', '2014-01-01 23:59:59'));
    }

    public function testSecondDateAfterFirstDate()
    {
        $direction = new Increasing();
        $this->assertEquals(-1, $direction->compare('2014-01-01 23:59:59', '2014-01-02 00:00:00'));
    }
}