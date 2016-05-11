<?php

namespace COG\ChronoShifter\Iterator;

use COG\ChronoShifter\Shifter\Shifter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Iterator\Domain
 */
class ChronoIterator implements \Iterator
{
    /**
     * @var Shifter
     */
    private $shifter;

    /**
     * @var string
     */
    private $date;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @param Shifter $shifter
     * @param string $date
     */
    public function __construct(Shifter $shifter, $date)
    {
        $this->shifter = $shifter;
        $this->date = $this->startDate = $date;

        $this->rewind();
    }

    /**
     * @return \DateTime
     */
    public function current()
    {
        return $this->date;
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->date = $this->shifter->shift($this->date);
    }

    /**
     * @return int
     */
    public function key()
    {
        return strtotime($this->date);
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
        $this->date = $this->startDate;
        $this->next();
    }
}