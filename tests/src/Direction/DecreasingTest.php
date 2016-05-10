<?php

namespace Tests\COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\Direction\Decreasing;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Direction\Tests
 */
class DecrementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @uses COG\ChronoShifter\Period\Period
     */
    public function testNextMovesToPreviousPeriod()
    {
        $periodMock = $this
            ->getMockBuilder('COG\ChronoShifter\Period\Period')
            ->setMethods(array('previous'))
            ->getMockForAbstractClass();

        $periodMock->expects($this->once())->method('previous');

        $direction = new Decreasing();
        $direction->next($periodMock);
    }

    public function testCompareEqualDates()
    {
        $direction = new Decreasing();
        $this->assertEquals(0, $direction->compare('2014-01-01 00:23:23', '2014-01-01 00:25:25'));
    }

    public function testFirstDateAfterSecondDate()
    {
        $direction = new Decreasing();
        $this->assertEquals(-1, $direction->compare('2014-01-02 00:00:00', '2014-01-01 23:59:59'));
    }

    public function testSecondDateAfterFirstDate()
    {
        $direction = new Decreasing();
        $this->assertEquals(1, $direction->compare('2014-01-01 23:59:59', '2014-01-02 00:00:00'));
    }
}
