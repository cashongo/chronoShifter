<?php

namespace COG\ChronoShifter\Date;

/**
 * Simple holiday provider if all possible holidays can be known ahead of time.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Date
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
    public function __construct(array $holidays)
    {
        $this->holidays = $holidays;
    }

    /**
     * @param \DateTime|string $date
     * @return bool
     */
    public function isHoliday(\DateTime $date)
    {
        return in_array($date->format('Y-m-d'), $this->holidays);
    }
}
