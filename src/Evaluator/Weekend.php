<?php

namespace COG\ChronoShifter\Evaluator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Domain
 */
class Weekend extends LogicalNot
{
    public function __construct()
    {
        parent::__construct(new Weekday());
    }
}
