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
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        $dateDecorator = new DateDecorator(new \DateTime($date));
        if ($dateDecorator->getDayOfMonth() >= min($this->calendarDay, $dateDecorator->getDaysInMonth())) {
            $dateDecorator->addMonth();
        }
        $dateDecorator->setDayOfMonth($this->getDayLimitedToDaysInMonth($dateDecorator->getDateTime()));

        return $dateDecorator->getDateTime()->format('Y-m-d');
    }
}
