<?php

namespace COG\ChronoShifter\Period;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Period\Domain
 */
class Month implements Period
{
    /**
     * @var int
     */
    private $month;

    /**
     * @var int
     */
    private $year;

    /**
     * @var int
     */
    private $daysInMonth;

    /**
     * @param string $date
     */
    public function __construct($date)
    {
        $this->setFromTimestamp(strtotime($date));
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return sprintf('%04d-%02d-01', $this->year, $this->month);
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return sprintf('%04d-%02d-%02d', $this->year, $this->month, $this->daysInMonth);
    }

    public function next()
    {
        $timestamp = strtotime('first day of +1 month', strtotime($this->getStartDate()));
        $this->setFromTimestamp($timestamp);
    }

    public function previous()
    {
        $timestamp = strtotime('first day of -1 month', strtotime($this->getStartDate()));
        $this->setFromTimestamp($timestamp);
    }

    /**
     * @return int
     */
    public function getNumberOfDays()
    {
        $end = new \DateTime($this->getEndDate());
        $start = new \DateTime($this->getStartDate());

        return $end->diff($start)->days;
    }

    /**
     * @param int $timestamp
     */
    private function setFromTimestamp($timestamp)
    {
        $this->year = (int)date('Y', $timestamp);
        $this->month = (int)date('n', $timestamp);
        $this->daysInMonth = (int)date('t', strtotime($this->getStartDate()));
    }
}
