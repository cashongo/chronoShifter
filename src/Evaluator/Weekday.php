<?php

namespace COG\ChronoShifter\Evaluator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Domain
 */
class Weekday implements Evaluator
{
    /**
     * @param string $date
     * @return bool
     */
    public function is($date)
    {
        return date('N', strtotime($date)) <= 5;
    }
}
