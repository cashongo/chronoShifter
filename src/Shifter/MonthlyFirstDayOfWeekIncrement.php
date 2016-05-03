<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increments days until first match with specified week day in beginning of
 * the month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyFirstDayOfWeekIncrement extends DayOfWeekShifter
{
    /**
     * @param \DateTime $date
     */
    public function shift(\DateTime $date) {
        $date->setTime(0, 0, 0);

        $firstCalendarDayWithDayOfWeek =
            $this->getFirstCalendarDayWithDayOfWeek($date, $this->dayOfWeek);

        if ((int) $date->format('j') >= $firstCalendarDayWithDayOfWeek) {
            $date->add(new \DateInterval('P1M'));
        }

        $this->setCalendarDay(
            $date,
            $this->getFirstCalendarDayWithDayOfWeek($date, $this->dayOfWeek)
        );
    }
}