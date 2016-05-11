<?php

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Evaluator\Evaluator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class FirstFrom implements Shifter
{
    /**
     * @var Evaluator
     */
    private $evaluator;

    /**
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * /**
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        while (!$this->evaluator->is($date)) {
            $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }

        return $date;
    }
}
