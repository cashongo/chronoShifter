<?php

namespace COG\ChronoShifter\Shifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class InnerShifter
{
    /**
     * @var Shifter
     */
    private $innerShifter;

    /**
     * @param Shifter $shifter
     */
    public function __construct(Shifter $shifter)
    {
        $this->innerShifter = $shifter;
    }

    /**
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        return $this->innerShifter->shift($date);
    }

    /**
     * @return Shifter
     */
    public function getInnerShifter()
    {
        return $this->innerShifter;
    }
}
