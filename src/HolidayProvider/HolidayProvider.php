<?php

namespace COG\ChronoShifter\HolidayProvider;

/**
 * An adapter interface to use application specific holiday logic for time
 * iterations.
 *
 * Holidays are specific to cultural regions and the implementations vary per
 * application.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package HolidayProvider\Domain
 */
interface HolidayProvider
{
    /**
     * @param string $date
     * @return boolean
     */
    public function isHoliday($date);
}
