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
     * @param \DateTime $date
     */
    public function shift(\DateTime $date) {
        $date->setTime(0, 0, 0);

        if ((int) $date->format('d') <= $this->calendarDay) {
            $date->sub(new \DateInterval('P1M'));
        }

        $this->setCalendarDay($date, $this->limitCalendarDay($date));
    }
}
