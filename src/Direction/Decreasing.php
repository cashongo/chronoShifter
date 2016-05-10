<?php

namespace COG\ChronoShifter\Direction;

use COG\ChronoShifter\Period\Period;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Direction\Domain
 */
class Decreasing implements Direction
{
    /**
     * @param Period $period
     */
    public function next(Period $period)
    {
        $period->previous();
    }

    /**
     * @param string $first
     * @param string $second
     * @return int
     */
    public function compare($first, $second)
    {
        // Discard time info
        $first = substr($first, 0, 10);
        $second = substr($second, 0, 10);

        if ($first === $second) {
            $result = 0;
        } else if (new \DateTime($first) > new \DateTime($second)) {
            $result = -1;
        } else {
            $result = 1;
        }

        return $result;
    }
}
