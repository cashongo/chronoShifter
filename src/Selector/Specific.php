<?php

namespace COG\ChronoShifter\Selector;

use COG\ChronoShifter\Direction\Direction;
use COG\ChronoShifter\Period\Period;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Selector\Domain
 */
class Specific implements Selector
{
    /**
     * @var Direction
     */
    private $direction;

    /**
     * @var int
     */
    private $number;

    /**
     * @param Direction $direction
     * @param int $number
     */
    public function __construct(Direction $direction, $number)
    {
        if (false === filter_var($number, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException('Integer required');
        }

        if ($number <= 0) {
            throw new \OutOfBoundsException('Day of month less than 1');
        }

        $this->direction = $direction;
        $this->number = $number;
    }

    /**
     * @param string $date
     * @param Period $period
     * @return string
     */
    public function select($date, Period $period)
    {
        $numberOfDays = min($this->number - 1, $period->getNumberOfDays());
        $result = $this->getDateAfterNumberOfDays($period->getStartDate(), $numberOfDays);

        if ($this->direction->compare($date, $result) !== -1) {
            $this->direction->next($period);
            $numberOfDays = min($this->number - 1, $period->getNumberOfDays());
            $result = $this->getDateAfterNumberOfDays($period->getStartDate(), $numberOfDays);
        }

        return $result;
    }

    /**
     * @param string $date
     * @param int $numberOfDays
     * @return string
     */
    private function getDateAfterNumberOfDays($date, $numberOfDays)
    {
        $startDate = new \DateTime($date);
        $startDate->add(new \DateInterval(sprintf('P%dD', $numberOfDays)));

        return $startDate->format('Y-m-d');
    }
}
