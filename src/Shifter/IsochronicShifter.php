<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Base class for isochronic shifters iterating on an isochronic axis of time.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
abstract class IsochronicShifter implements Shifter
{
    const SECONDS_IN_DAY = 86400;

    /**
     * Interval in seconds
     *
     * @var int
     */
    protected $interval;

    /**
     * @var int
     */
    protected $referenceOffset;

    /**
     * @param int $days
     * @param string $referenceDate
     */
    public function __construct($days, $referenceDate)
    {
        $this->interval = $days * self::SECONDS_IN_DAY;
        $this->referenceOffset = $this->getIsochronicOffset(new \DateTime($referenceDate));
    }

    /**
     * @param string $date
     * @return string
     */
    abstract public function shift($date);

    /**
     * @param \DateTime $time
     * @return int
     */
    protected function getIsochronicOffset(\DateTime $time)
    {
        return $this->skipTimeAndTimezone($time) % $this->interval;
    }

    /**
     * @param \DateTime $time
     * @return int
     */
    private function skipTimeAndTimezone(\DateTime $time)
    {
        $result = new \DateTime();
        $result->setTimezone(new \DateTimeZone('UTC'));
        $result->setTime(0, 0, 0);
        $result->setDate(
            $time->format('Y'),
            $time->format('n'),
            $time->format('j')
        );

        return (int)$result->format('U');
    }
}