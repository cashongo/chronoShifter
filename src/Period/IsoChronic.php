<?php

namespace COG\ChronoShifter\Period;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Period\Domain
 */
class IsoChronic implements Period
{
    /**
     * @var string
     */
    private $referenceDate;

    /**
     * @var int
     */
    private $length;

    /**
     * @var string
     */
    private $startDate;

    /**
     * @var string
     */
    private $endDate;

    /**
     * @param string $date
     */
    public function __construct($date, $referenceDate, $length)
    {
        $this->referenceDate = substr($referenceDate, 0, 10);
        $this->length = $length;

        $this->setDate(substr($date, 0, 10));
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function getNumberOfDays()
    {
        return $this->length - 1;
    }

    public function next()
    {
        $this->setDate(date('Y-m-d', strtotime(sprintf('+%d day', $this->length), strtotime($this->startDate))));
    }

    public function previous()
    {
        $this->setDate(date('Y-m-d', strtotime(sprintf('-%d day', $this->length), strtotime($this->startDate))));
    }

    /**
     * @param string $date
     */
    private function setDate($date)
    {
        $date = new \DateTime($date);
        $referenceDate = new \DateTime($this->referenceDate);
        $offset = $referenceDate->diff($date)->days;

        if ($referenceDate > $date) {
            $days = ceil($offset / $this->length) * $this->length;
            $this->startDate = date('Y-m-d', strtotime(sprintf('-%d day', $days), strtotime($referenceDate->format('Y-m-d'))));
        } else {
            $days = floor($offset / $this->length) * $this->length;
            $this->startDate = date('Y-m-d', strtotime(sprintf('+%d day', $days), strtotime($referenceDate->format('Y-m-d'))));
        }

        $this->endDate = date('Y-m-d', strtotime(sprintf('+%d day', $this->length - 1), strtotime($this->startDate)));
    }
}