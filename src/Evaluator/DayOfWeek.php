<?php

namespace COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\HolidayProvider\HolidayProvider;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Domain
 */
class DayOfWeek implements Evaluator
{
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;

    /**
     * @var HolidayProvider
     */
    private $weekday;

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

        $this->weekday = (int)$dayOfWeek;
    }

    /**
     * @param string $date
     * @return bool
     */
    public function is($date)
    {
        return (int)date('N', strtotime($date)) === $this->weekday;
    }
}
