<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Decrements the date to first day with specified calendar day.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
class CalendarDayDecrement extends CalendarDayShifter
{
    /**
     * @param \DateTime $time
     */
    public function shift(\DateTime $time) {
        $time->setTime(0, 0, 0);

        if ((int) $time->format('d') <= $this->calendarDay) {
            $time->sub(new \DateInterval('P1M'));
        }

        $this->setCalendarDay($time, $this->limitCalendarDay($time));
    }
}
