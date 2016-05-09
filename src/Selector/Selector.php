<?php

namespace COG\ChronoShifter\Selector;

use COG\ChronoShifter\Period\Period;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Selector\Domain
 */
interface Selector
{
    /**
     * @param string $date
     * @param Period $period
     * @return string
     */
    public function select($date, Period $period);
}
