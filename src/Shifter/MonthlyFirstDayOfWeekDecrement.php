<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Decrements days until first match with specified week day in beginning of
 * the month.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyFirstDayOfWeekDecrement extends DayOfWeekShifter
{
    /**
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        $dateTime = new \DateTime($date);

        $firstCalendarDayWithDayOfWeek =
            $this->getFirstDayOfMonthHavingDayOfWeek($dateTime, $this->dayOfWeek);

        if ((int)$dateTime->format('j') <= $firstCalendarDayWithDayOfWeek) {
            $dateTime->sub(new \DateInterval('P1M'));
        }

        $this->setCalendarDay(
            $dateTime,
            $this->getFirstDayOfMonthHavingDayOfWeek($dateTime, $this->dayOfWeek)
        );

        return $dateTime->format('Y-m-d');
    }
}
