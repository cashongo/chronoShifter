<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increment or decrement time
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
interface Shifter
{
    /**
     * @param \DateTime $time
     */
    public function shift(\DateTime $time);
}