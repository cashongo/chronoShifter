<?php

namespace Tests\COG\ChronoShifter\Period;
use COG\ChronoShifter\Period\IsoChronic;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Period\Test
 */
class IsoChronicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider isoChronicBoundaryProvider
     * @param string $date
     * @param string $referenceDate
     * @param int $length
     * @param string $startDate
     * @param string $endDate
     */
    public function testIsoChronicBoundaries($date, $referenceDate, $length, $startDate, $endDate)
    {
        $isoChronic = new IsoChronic($date, $referenceDate, $length);
        $this->assertEquals($startDate, $isoChronic->getStartDate());
        $this->assertEquals($endDate, $isoChronic->getEndDate());
    }

    public function isoChronicBoundaryProvider()
    {
        return array(
            array('2014-01-03', '2014-01-01', 2, '2014-01-03', '2014-01-04'),
            array('2014-01-02', '2014-01-01', 2, '2014-01-01', '2014-01-02'),
            array('2014-01-01', '2014-01-01', 2, '2014-01-01', '2014-01-02'),
            array('2013-12-31', '2014-01-01', 2, '2013-12-30', '2013-12-31'),
            array('2013-12-30', '2014-01-01', 2, '2013-12-30', '2013-12-31'),
            array('2013-12-29', '2014-01-01', 2, '2013-12-28', '2013-12-29')
        );
    }

    /**
     * @dataProvider isoChronicIncreaseProvider
     * @param string $date
     * @param string $referenceDate
     * @param int $length
     * @param string $startDate
     * @param string $endDate
     */
    public function testIsoChronicIncrease($date, $referenceDate, $length, $startDate, $endDate)
    {
        $isoChronic = new IsoChronic($date, $referenceDate, $length);
        $isoChronic->next();
        $this->assertEquals($startDate, $isoChronic->getStartDate());
        $this->assertEquals($endDate, $isoChronic->getEndDate());
    }

    public function isoChronicIncreaseProvider()
    {
        return array(
            array('2014-01-03', '2014-01-01', 2, '2014-01-05', '2014-01-06'),
            array('2014-01-02', '2014-01-01', 2, '2014-01-03', '2014-01-04'),
            array('2014-01-01', '2014-01-01', 2, '2014-01-03', '2014-01-04'),
            array('2013-12-31', '2014-01-01', 2, '2014-01-01', '2014-01-02'),
            array('2013-12-30', '2014-01-01', 2, '2014-01-01', '2014-01-02'),
            array('2013-12-29', '2014-01-01', 2, '2013-12-30', '2013-12-31')
        );
    }

    /**
     * @dataProvider isoChronicDecreaseProvider
     * @param string $date
     * @param string $referenceDate
     * @param int $length
     * @param string $startDate
     * @param string $endDate
     */
    public function testIsoChronicDecrease($date, $referenceDate, $length, $startDate, $endDate)
    {
        $isoChronic = new IsoChronic($date, $referenceDate, $length);
        $isoChronic->previous();
        $this->assertEquals($startDate, $isoChronic->getStartDate());
        $this->assertEquals($endDate, $isoChronic->getEndDate());
    }

    public function isoChronicDecreaseProvider()
    {
        return array(
            array('2014-01-03', '2014-01-01', 2, '2014-01-01', '2014-01-02'),
            array('2014-01-02', '2014-01-01', 2, '2013-12-30', '2013-12-31'),
            array('2014-01-01', '2014-01-01', 2, '2013-12-30', '2013-12-31'),
            array('2013-12-31', '2014-01-01', 2, '2013-12-28', '2013-12-29'),
            array('2013-12-30', '2014-01-01', 2, '2013-12-28', '2013-12-29'),
            array('2013-12-29', '2014-01-01', 2, '2013-12-26', '2013-12-27')
        );
    }
}