<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Decrement date isochronically using a point of reference to first match on
 * the axis of time.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
class IsochronicDecrement extends IsochronicShifter
{
    private $initTzOffset;

    /**
     * @param \DateTime $time
     */
    public function shift(\DateTime $time) {
        $time->setTime(0, 0, 0);

        $timestamp = (int) $time->format('U');

        $this->calculateInitialTimezoneOffset($time);

        $offset = $this->getIsochronicOffset($time);

        $decrementBy = $offset - $this->referenceOffset;

        if ($this->referenceOffset >= $offset) {
            $decrementBy += $this->interval;
        }

        $newTimestamp = $timestamp - $decrementBy;

        $time->setTimestamp($newTimestamp);

        if($tzOffset = $this->getOffsetForTimezone($time)) {
            $time->setTimestamp($newTimestamp + $tzOffset);
        }
    }

    /**
     * @param \DateTime $time
     */
    private function calculateInitialTimezoneOffset(\DateTime $time) {
        $this->initTzOffset = $time->getTimezone()->getOffset($time);
    }

    /**
     * @param \DateTime $time
     * @return int
     */
    private function getOffsetForTimezone(\DateTime $time) {
        $finalOffset = $time->getTimezone()->getOffset($time);
        return ($this->initTzOffset - $finalOffset);
    }
}