<?php

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Period\Period;
use COG\ChronoShifter\Selector\Selector;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class ChronoShifter
{
    /**
     * @var Period
     */
    private $period;

    /**
     * @var Selector
     */
    private $selector;

    /**
     * PeriodShifter constructor.
     * @param Selector $selector
     * @param Period $period
     */
    public function __construct(Period $period, Selector $selector)
    {
        $this->period = $period;
        $this->selector = $selector;
    }

    /**
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        return $this->selector->select($date, $this->period);
    }
}
