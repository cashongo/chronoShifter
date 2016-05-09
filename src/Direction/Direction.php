<?php

namespace COG\ChronoShifter\Direction;

use COG\ChronoShifter\Period\Period;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Direction\Domain
 */
interface Direction
{
    /**
     * @param Period $period
     */
    public function next(Period $period);

    /**
     * @param string $first
     * @param string $second
     * @return int
     */
    public function compare($first, $second);
}
