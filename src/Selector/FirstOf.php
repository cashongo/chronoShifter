<?php

namespace COG\ChronoShifter\Selector;

use COG\ChronoShifter\Direction\Direction;
use COG\ChronoShifter\Evaluator\Evaluator;
use COG\ChronoShifter\Period\Period;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Selector\Domain
 */
class FirstOf implements Selector
{
    /**
     * @var Direction
     */
    private $direction;

    /**
     * @var Evaluator
     */
    private $evaluator;

    /**
     * @param Direction $direction
     * @param Evaluator $evaluator
     */
    public function __construct(Direction $direction, Evaluator $evaluator)
    {
        $this->direction = $direction;
        $this->evaluator = $evaluator;
    }

    /**
     * @param string $date
     * @param Period $period
     * @return string
     */
    public function select($date, Period $period)
    {
        $match = $this->getFirstInPeriod(
            new \DateTime($period->getStartDate()),
            new \DateTime($period->getEndDate())
        );

        if ($this->direction->compare($date, $match) !== -1) {
            $this->direction->next($period);
            $match = $this->getFirstInPeriod(
                new \DateTime($period->getStartDate()),
                new \DateTime($period->getEndDate())
            );
        }

        return $match;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return null|string
     * @throws \LogicException
     */
    private function getFirstInPeriod(\DateTime $startDate, \DateTime $endDate)
    {
        $match = null;

        for ($i = clone $startDate; $i < $endDate; $i->add(new \DateInterval('P1D'))) {
            if ($this->evaluator->is($i->format('Y-m-d'))) {
                $match = $i->format('Y-m-d');
                break;
            }
        }

        if ($match === null) {
            throw new \LogicException('No match in period');
        }

        return $match;
    }
}
