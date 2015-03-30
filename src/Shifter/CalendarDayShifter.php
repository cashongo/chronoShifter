<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Based class for calendar day shifters.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
abstract class CalendarDayShifter implements Shifter
{
    /**
     * @var int
     */
    protected $calendarDay;

    /**
     * @param int $calendarDay 1-31
     */
    public function __construct($calendarDay) {
        if (false === filter_var($calendarDay, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException('Integer required');
        }

        if ($calendarDay <= 0) {
            throw new \OutOfBoundsException('Day of month less than 1');
        }

        if ($calendarDay > 31) {
            throw new \OutOfBoundsException('Day of month greater than 31');
        }

        $this->calendarDay = (int) $calendarDay;
    }

    /**
     * @param \DateTime $time
     */
    abstract public function shift(\DateTime $time);

    /**
     * @param \DateTime $time
     * @return mixed
     */
    protected function limitCalendarDay(\DateTime $time) {
        return min($this->calendarDay, (int) $time->format('t'));
    }

    /**
     * @param \DateTime $time
     * @param $day
     */
    protected function setCalendarDay(\DateTime $time, $day) {
        $time->setDate($time->format('Y'), $time->format('n'), $day);
    }
}