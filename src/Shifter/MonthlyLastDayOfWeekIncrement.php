<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increments days until first match with specified week day in end of
 * the month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
class MonthlyLastDayOfWeekIncrement extends DayOfWeekShifter
{
    /**
     * @param \DateTime $time
     */
    public function shift(\DateTime $time) {
        $time->setTime(0, 0, 0);

        $lastCalendarDayWithDayOfWeek =
            $this->getLastCalendarDayWithDayOfWeek($time, $this->dayOfWeek);

        if ((int) $time->format('j') >= $lastCalendarDayWithDayOfWeek) {
            $time->add(new \DateInterval('P1M'));
        }

        $this->setCalendarDay(
            $time,
            $this->getLastCalendarDayWithDayOfWeek($time, $this->dayOfWeek)
        );
    }
}