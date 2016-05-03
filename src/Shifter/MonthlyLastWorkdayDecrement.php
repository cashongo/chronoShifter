<?php
/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\DateDecorator;
use COG\ChronoShifter\Date\HolidayProvider;

/**
 * Decrements to previous matching non-holiday weekday (M-F) of month
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyLastWorkdayDecrement
{
    /**
     * @var \COG\ChronoShifter\Date\HolidayProvider
     */
    private $holidayProvider;

    /**
     * @param \DateTime $dateTime
     */
    public function shift(\DateTime $dateTime)
    {
        if (!$this->holidayProvider instanceof HolidayProvider) {
            throw new \LogicException('Holiday provider required');
        }
        $date = new DateDecorator($dateTime);
        $date->setHolidayProvider($this->holidayProvider);
        $dayOfMonth = $date->getDayOfMonth();
        $date->toLastWorkday();
        if ($date->getDayOfMonth() >= $dayOfMonth) {
            $date->subtractMonth()->toLastWorkday();
        }
    }

    /**
     * @return HolidayProvider
     */
    public function getHolidayProvider()
    {
        return $this->holidayProvider;
    }

    /**
     * @param HolidayProvider $provider
     */
    public function setHolidayProvider(HolidayProvider $provider)
    {
        $this->holidayProvider = $provider;
    }
}