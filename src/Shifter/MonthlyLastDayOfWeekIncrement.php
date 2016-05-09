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
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        $dateTime = new \DateTime($date);

        $lastCalendarDayWithDayOfWeek =
            $this->getLastDayOfMonthHavingDayOfWeek($dateTime, $this->dayOfWeek);

        if ((int)$dateTime->format('j') >= $lastCalendarDayWithDayOfWeek) {
            $dateTime->add(new \DateInterval('P1M'));
        }

        $this->setCalendarDay(
            $dateTime,
            $this->getLastDayOfMonthHavingDayOfWeek($dateTime, $this->dayOfWeek)
        );

        return $dateTime->format('Y-m-d');
    }
}