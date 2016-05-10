<?php

namespace COG\ChronoShifter\Iterator\Filter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Iterator\Filter\Domain
 */
class OnOrBefore extends \FilterIterator
{
    /**
     * @var string
     */
    private $date;

    /**
     * @param \Iterator $iterator
     * @param string $date
     */
    public function __construct(\Iterator $iterator, $date)
    {
        parent::__construct($iterator);
        $this->date = substr($date, 0, 10);
    }

    /**
     * @return bool
     */
    public function accept()
    {
        $current = new \DateTime(parent::current());
        $current->setTime(0, 0, 0);

        return $current <= new \DateTime($this->date);
    }
}
