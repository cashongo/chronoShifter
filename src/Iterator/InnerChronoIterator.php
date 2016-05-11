<?php

namespace COG\ChronoShifter\Iterator;

use COG\ChronoShifter\Shifter\Shifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Iterator\Domain
 */
class InnerChronoIterator extends ChronoIterator
{
    /**
     * @var Shifter
     */
    private $outerShifter;

    /**
     * @param Shifter $innerShifter
     * @param Shifter $outerShifter
     * @param string $date
     */
    public function __construct(Shifter $innerShifter, Shifter $outerShifter, $date)
    {
        parent::__construct($innerShifter, $date);
        $this->outerShifter = $outerShifter;
    }

    /**
     * @return string
     */
    public function current()
    {
        return $this->outerShifter->shift(parent::current());
    }
}
