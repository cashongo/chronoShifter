<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increments the date to first day with specified calendar day.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
class CalendarDayIncrement extends CalendarDayShifter
{
    /**
     * @param \DateTime $date
     */
    public function shift(\DateTime $date) {
        $date->setTime(0, 0, 0);

        if ((int) $date->format('d') >= $this->calendarDay) {
            $date->add(new \DateInterval('P1M'));
        }

        $this->setCalendarDay($date, $this->limitCalendarDay($date));
    }
}
