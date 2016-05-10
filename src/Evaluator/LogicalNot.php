<?php

namespace COG\ChronoShifter\Evaluator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Domain
 */
class LogicalNot implements Evaluator
{
    /**
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * @param string $date
     * @return bool
     */
    public function is($date)
    {
        return !$this->evaluator->is($date);
    }
}
