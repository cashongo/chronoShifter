<?php

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Evaluator\Evaluator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class FirstMatchAfter extends InnerShifter
{
    /**
     * @var Evaluator
     */
    private $evaluator;

    /**
     * @param Shifter $shifter
     * @param Evaluator $evaluator
     */
    public function __construct(Shifter $shifter, Evaluator $evaluator)
    {
        parent::__construct($shifter);
        $this->evaluator = $evaluator;
    }

    /**
     * /**
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        $value = $this->getInnerShifter()->shift($date);

        while (!$this->evaluator->is($this->getInnerShifter()->shift($value))) {
            $value = date('Y-m-d', strtotime('+1 day', strtotime($value)));
        }

        return $value;
    }
}
