<?php

namespace COG\ChronoShifter\Evaluator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Domain
 */
interface Evaluator
{
    /**
     * @param string $date
     * @return int
     */
    public function is($date);
}
