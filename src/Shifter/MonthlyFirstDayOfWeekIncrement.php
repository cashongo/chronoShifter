<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increments days until first match with specified week day in beginning of
 * the month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
class MonthlyFirstDayOfWeekIncrement extends DayOfWeekShifter
{
    /**
     * @param \DateTime $time
     */
    public function shift(\DateTime $time) {
        $time->setTime(0, 0, 0);

        $firstCalendarDayWithDayOfWeek =
            $this->getFirstCalendarDayWithDayOfWeek($time, $this->dayOfWeek);

        if ((int) $time->format('j') >= $firstCalendarDayWithDayOfWeek) {
            $time->add(new \DateInterval('P1M'));
        }

        $this->setCalendarDay(
            $time,
            $this->getFirstCalendarDayWithDayOfWeek($time, $this->dayOfWeek)
        );
    }
}