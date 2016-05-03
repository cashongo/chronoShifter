<?php

namespace COG\ChronoShifter;

use COG\ChronoShifter\Shifter\Shifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Domain
 */
class ChronoShifter implements \Iterator
{
    /**
     * @var Shifter
     */
    private $shifter;

    /**
     * @var \DateTime
     */
    private $time;

    /**
     * @param Shifter $shifter
     * @param \DateTime $time
     */
    public function __construct(Shifter $shifter, \DateTime $time = null)
    {
        $this->shifter = $shifter;
        $this->time = $time;
    }

    /**
     * @return \DateTime
     */
    public function current()
    {
        return $this->time;
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->shifter->shift($this->time);
    }

    /**
     * @return int
     */
    public function key()
    {
        return (int)$this->time->format('U');
    }

    /**
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return true;
    }

    /**
     * @return void
     */
    public function rewind()
    {
    }
}