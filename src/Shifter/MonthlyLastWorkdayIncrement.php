<?php
/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\DateDecorator;
use COG\ChronoShifter\Date\HolidayProvider;

/**
 * Increments to next matching non-holiday weekday (M-F) of month
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyLastWorkdayIncrement implements Shifter
{
    /**
     * @var \COG\ChronoShifter\Date\HolidayProvider
     */
    private $holidayProvider;

    /**
     * @param HolidayProvider $provider
     */
    public function __construct(HolidayProvider $provider)
    {
        $this->holidayProvider = $provider;
    }

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
        if ($date->getDayOfMonth() <= $dayOfMonth) {
            $date->addMonth()->toLastWorkday();
        }
    }
}
