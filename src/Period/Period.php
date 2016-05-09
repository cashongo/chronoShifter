<?php

namespace COG\ChronoShifter\Period;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Period\Domain
 */
interface Period
{
    /**
     * @return string
     */
    public function getStartDate();

    /**
     * @return string
     */
    public function getEndDate();

    /**
     * @return int
     */
    public function getNumberOfDays();

    public function next();

    public function previous();
}
