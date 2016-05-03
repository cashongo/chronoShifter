<?php
/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\DateDecorator;
use COG\ChronoShifter\Date\HolidayProvider;

/**
 * Decrements to previous matching first non-holiday weekday (M-F) of month
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyFirstWorkdayDecrement implements Shifter
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
        $date->toFirstWorkday();
        if ($date->getDayOfMonth() >= $dayOfMonth) {
            $date->subtractMonth()->toFirstWorkday();
        }
    }
}