<?php

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\DateDecorator;

/**
 * Increments the date to first day with specified day of month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class DayOfMonthIncrement extends DayOfMonthShifter
{
    /**
     * @param \DateTime $dateTime
     */
    public function shift(\DateTime $dateTime)
    {
        $date = new DateDecorator($dateTime);
        if ($date->getDayOfMonth() >= min($this->calendarDay, $date->getDaysInMonth())) {
            $date->addMonth();
        }
        $date->setDayOfMonth($this->getDayLimitedToDaysInMonth($date->getDateTime()));
    }
}
