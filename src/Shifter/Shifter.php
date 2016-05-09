<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increment or decrement time
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
interface Shifter
{
    /**
     * @param string $date
     * @return string
     */
    public function shift($date);
}