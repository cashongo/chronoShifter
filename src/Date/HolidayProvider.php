<?php

namespace COG\ChronoShifter\Date;

/**
 * An adapter interface to use application specific holiday logic for time
 * iterations.
 *
 * Holidays are specific to cultural regions and the implementations vary per
 * application.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Date\Domain
 */
interface HolidayProvider
{
    /**
     * @param \DateTime $date
     * @return boolean
     */
    public function isHoliday(\DateTime $date);
}
