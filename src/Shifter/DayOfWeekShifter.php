<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Base class for day of week shifters.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
abstract class DayOfWeekShifter implements Shifter
{
    const MONDAY = 1;

    const TUESDAY = 2;

    const WEDNESDAY = 3;

    const THURSDAY = 4;

    const FRIDAY = 5;

    const SATURDAY = 6;

    const SUNDAY = 7;

    /**
     * @var int 1-7
     */
    protected $dayOfWeek;

    /**
     * @param int $dayOfWeek
     */
    public function __construct($dayOfWeek)
    {
        if (false === filter_var($dayOfWeek, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException('Integer required');
        }

        if ($dayOfWeek <= 0) {
            throw new \OutOfBoundsException('Day of week less than 1');
        }

        if ($dayOfWeek > 7) {
            throw new \OutOfBoundsException('Day of week greater than 7');
        }

        $this->dayOfWeek = $dayOfWeek;
    }

    /**
     * @param \DateTime $date
     */
    abstract public function shift(\DateTime $date);

    /**
     * @param \DateTime $time
     * @param $dayOfWeek
     * @return int
     */
    protected function getFirstCalendarDayWithDayOfWeek(
        \DateTime $time,
        $dayOfWeek
    ) {
        $dayOfWeekForFirstCalendarDay =
            $this->getDayOfWeekForFirstDayOfMonth($time);

        return (int)((7 - $dayOfWeekForFirstCalendarDay + $dayOfWeek) % 7) + 1;
    }

    /**
     * @param \DateTime $time
     * @param $dayOfWeek
     * @return int
     */
    protected function getLastCalendarDayWithDayOfWeek(
        \DateTime $time,
        $dayOfWeek
    ) {
        $daysInMonth = (int)$time->format('t');
        $dayOfWeekForLastCalendarDay =
            $this->getDayOfWeekForLastDayOfMonth($time);

        $offset = (int)((7 - $dayOfWeekForLastCalendarDay + $dayOfWeek) % 7);

        return $daysInMonth - 7 + $offset;
    }

    /**
     * @param \DateTime $time
     * @return int
     */
    protected function getDayOfWeekForFirstDayOfMonth(\DateTime $time)
    {
        return (int)date('N', $this->getTimestampForFirstDayOfMonth($time));
    }

    /**
     * @param \DateTime $time
     * @return int
     */
    protected function getDayOfWeekForLastDayOfMonth(\DateTime $time)
    {
        return (int)date('N', $this->getTimestampForLastDayOfMonth($time));
    }

    /**
     * @param \DateTime $time
     * @return int
     */
    protected function getTimestampForFirstDayOfMonth(\DateTime $time)
    {
        return mktime(
            null,
            null,
            null,
            $time->format('m'),
            1,
            $time->format('Y')
        );
    }

    /**
     * @param \DateTime $time
     * @return int
     */
    protected function getTimestampForLastDayOfMonth(\DateTime $time)
    {
        return mktime(
            null,
            null,
            null,
            $time->format('m'),
            $time->format('t'),
            $time->format('Y')
        );
    }

    /**
     * @param \DateTime $time
     * @param $day
     */
    protected function setCalendarDay(\DateTime $time, $day)
    {
        $time->setDate($time->format('Y'), $time->format('n'), $day);
    }

}