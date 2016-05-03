<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Decrements days until first match with specified week day in end of
 * the month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyLastDayOfWeekDecrement extends DayOfWeekShifter
{
    /**
     * @param \DateTime $date
     */
    public function shift(\DateTime $date)
    {
        $date->setTime(0, 0, 0);

        $firstCalendarDayWithDayOfWeek =
            $this->getLastCalendarDayWithDayOfWeek($date, $this->dayOfWeek);

        if ((int)$date->format('j') <= $firstCalendarDayWithDayOfWeek) {
            $date->sub(new \DateInterval('P1M'));
        }

        $this->setCalendarDay(
            $date,
            $this->getLastCalendarDayWithDayOfWeek($date, $this->dayOfWeek)
        );
    }
}