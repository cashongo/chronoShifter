<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Decrements days until first match with specified week day in end of
 * the month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
class MonthlyLastDayOfWeekDecrement extends DayOfWeekShifter
{
    /**
     * @param \DateTime $time
     */
    public function shift(\DateTime $time) {
        $time->setTime(0, 0, 0);

        $firstCalendarDayWithDayOfWeek =
            $this->getLastCalendarDayWithDayOfWeek($time, $this->dayOfWeek);

        if ((int) $time->format('j') <= $firstCalendarDayWithDayOfWeek) {
            $time->sub(new \DateInterval('P1M'));
        }

        $this->setCalendarDay(
            $time,
            $this->getLastCalendarDayWithDayOfWeek($time, $this->dayOfWeek)
        );
    }
}