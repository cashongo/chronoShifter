<?php

namespace COG\ChronoShifter\Evaluator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Domain
 */
class LogicalAnd implements Evaluator
{
    /**
     * @var Evaluator
     */
    protected $first;

    /**
     * @var Evaluator
     */
    protected $second;

    /**
     * @param Evaluator $first
     * @param Evaluator $second
     */
    public function __construct(Evaluator $first, Evaluator $second)
    {
        $this->first = $first;
        $this->second = $second;
    }

    /**
     * @param string $date
     * @return bool
     */
    public function is($date)
    {
        return $this->first->is($date) && $this->second->is($date);
    }
}
