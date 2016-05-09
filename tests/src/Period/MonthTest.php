<?php

namespace Tests\COG\ChronoShifter\Period;

use COG\ChronoShifter\Period\Month;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Period\Test
 */
class MonthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider createMonthByAnyDateInRangeProvider
     * @param string $date
     * @param string $startDate
     * @param string $endDate
     */
    public function testCreateMonthByAnyDateInRange($date, $startDate, $endDate)
    {
        $month = new Month($date);

        $this->assertEquals($startDate, $month->getStartDate());
        $this->assertEquals($endDate, $month->getEndDate());
    }

    /**
     * @return array
     */
    public function createMonthByAnyDateInRangeProvider()
    {
        return array(
            array('1999-12-31', '1999-12-01', '1999-12-31'),
            array('2000-01-01', '2000-01-01', '2000-01-31'),
            array('2000-02-15', '2000-02-01', '2000-02-29')
        );
    }

    /**
     * @dataProvider nextMonthProvider
     * @param string $date
     * @param string $startDate
     * @param string $endDate
     */
    public function testNextMonth($date, $startDate, $endDate)
    {
        $month = new Month($date);
        $month->next();

        $this->assertEquals($startDate, $month->getStartDate());
        $this->assertEquals($endDate, $month->getEndDate());
    }

    /**
     * @return array
     */
    public function nextMonthProvider()
    {
        return array(
            array('1999-11-30', '1999-12-01', '1999-12-31'),
            array('1999-12-31', '2000-01-01', '2000-01-31'),
            array('2000-01-15', '2000-02-01', '2000-02-29'),
            array('2000-02-01', '2000-03-01', '2000-03-31'),
            array('2000-03-01', '2000-04-01', '2000-04-30'),
            array('2000-04-01', '2000-05-01', '2000-05-31'),
            array('2000-05-01', '2000-06-01', '2000-06-30'),
            array('2000-06-01', '2000-07-01', '2000-07-31'),
            array('2000-07-01', '2000-08-01', '2000-08-31'),
            array('2000-08-01', '2000-09-01', '2000-09-30'),
            array('2000-09-01', '2000-10-01', '2000-10-31'),
            array('2000-10-01', '2000-11-01', '2000-11-30'),
            array('2000-11-01', '2000-12-01', '2000-12-31'),
            array('2000-12-01', '2001-01-01', '2001-01-31'),
        );
    }

    /**
     * @dataProvider previousMonthProvider
     * @param string $date
     * @param string $startDate
     * @param string $endDate
     */
    public function testPreviousMonth($date, $startDate, $endDate)
    {
        $month = new Month($date);
        $month->previous();

        $this->assertEquals($startDate, $month->getStartDate());
        $this->assertEquals($endDate, $month->getEndDate());
    }

    /**
     * @return array
     */
    public function previousMonthProvider()
    {
        return array(
            array('1999-11-30', '1999-10-01', '1999-10-31'),
            array('1999-12-31', '1999-11-01', '1999-11-30'),
            array('2000-01-15', '1999-12-01', '1999-12-31'),
            array('2000-02-01', '2000-01-01', '2000-01-31'),
            array('2000-03-01', '2000-02-01', '2000-02-29'),
            array('2000-04-01', '2000-03-01', '2000-03-31'),
            array('2000-05-01', '2000-04-01', '2000-04-30'),
            array('2000-06-01', '2000-05-01', '2000-05-31'),
            array('2000-07-01', '2000-06-01', '2000-06-30'),
            array('2000-08-01', '2000-07-01', '2000-07-31'),
            array('2000-09-01', '2000-08-01', '2000-08-31'),
            array('2000-10-01', '2000-09-01', '2000-09-30'),
            array('2000-11-01', '2000-10-01', '2000-10-31'),
            array('2000-12-01', '2000-11-01', '2000-11-30')
        );
    }

    public function testGetNumberOfDays()
    {
        $month = new Month('2015-02-15');
        $this->assertEquals(27, $month->getNumberOfDays());
    }
}
