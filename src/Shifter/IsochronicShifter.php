<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Base class for isochronic shifters iterating on an isochronic axis of time.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
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
     * @param \DateTime $referenceDate
     */
    public function __construct($days, \DateTime $referenceDate) {
        $this->interval = $days * self::SECONDS_IN_DAY;
        $this->referenceOffset = $this->getIsochronicOffset($referenceDate);
    }

    /**
     * @param \DateTime $time
     */
    abstract public function shift(\DateTime $time);

    /**
     * @param \DateTime $time
     * @return int
     */
    protected function getIsochronicOffset(\DateTime $time) {
        return $this->skipTimeAndTimezone($time) % $this->interval;
    }

    /**
     * @param \DateTime $time
     * @return int
     */
    private function skipTimeAndTimezone(\DateTime $time) {
        $result = new \DateTime();
        $result->setTimezone(new \DateTimeZone('UTC'));
        $result->setTime(0, 0, 0);
        $result->setDate(
            $time->format('Y'),
            $time->format('n'),
            $time->format('j')
        );
        return (int) $result->format('U');
    }
}