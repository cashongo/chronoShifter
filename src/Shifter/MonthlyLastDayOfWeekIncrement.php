<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increments days until first match with specified week day in end of
 * the month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyLastDayOfWeekIncrement extends DayOfWeekShifter
{
    /**
     * @param \DateTime $date
     */
    public function shift(\DateTime $date) {
        $date->setTime(0, 0, 0);

        $lastCalendarDayWithDayOfWeek =
            $this->getLastCalendarDayWithDayOfWeek($date, $this->dayOfWeek);

        if ((int) $date->format('j') >= $lastCalendarDayWithDayOfWeek) {
            $date->add(new \DateInterval('P1M'));
        }

        $this->setCalendarDay(
            $date,
            $this->getLastCalendarDayWithDayOfWeek($date, $this->dayOfWeek)
        );
    }
}