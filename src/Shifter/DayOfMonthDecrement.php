<?php

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\Date;

/**
 * Decrements the date to first day with specified day of month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class DayOfMonthDecrement extends DayOfMonthShifter
{
    /**
     * @param \DateTime $dateTime
     */
    public function shift(\DateTime $dateTime)
    {
        $date = new Date($dateTime);
        if ($date->getDayOfMonth() <= $this->calendarDay) {
            $date->subtractMonth();
        }
        $date->setDayOfMonth($this->getDayLimitedToDaysInMonth($date->getDateTime()));
    }
}
