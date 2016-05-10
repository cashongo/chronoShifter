<?php

namespace COG\ChronoShifter\HolidayProvider;

/**
 * Simple holiday provider if all possible holidays can be known ahead of time.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package HolidayProvider\Domain
 */
class ArrayHolidayProvider implements HolidayProvider
{
    /**
     * @var string[]
     */
    private $holidays;

    /**
     * @param string[] $holidays List of holidays each in YYYY-MM-DD format.
     */
    public function __construct(array $holidays = array())
    {
        $this->holidays = $holidays;
    }

    /**
     * @param \DateTime|string $date
     * @return bool
     */
    public function isHoliday($date)
    {
        return in_array(substr($date, 0, 10), $this->holidays);
    }
}
