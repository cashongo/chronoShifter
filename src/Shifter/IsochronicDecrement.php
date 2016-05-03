<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Decrement date isochronically using a point of reference to first match on
 * the axis of time.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class IsochronicDecrement extends IsochronicShifter
{
    private $initTzOffset;

    /**
     * @param \DateTime $date
     */
    public function shift(\DateTime $date) {
        // Ignore time
        $date->setTime(0, 0, 0);

        // Current timestamp
        $timestamp = (int) $date->format('U');

        // Store current timezone offset
        $this->calculateInitialTimezoneOffset($date);

        // Calculate distance to previous isochronic timestamp
        $isochronicOffset = $this->getIsochronicOffset($date);
        $decrementBy = $isochronicOffset - $this->referenceOffset;
        if ($this->referenceOffset >= $isochronicOffset) {
            $decrementBy += $this->interval;
        }

        // Calculate new timestamp
        $newTimestamp = $timestamp - $decrementBy;
        $date->setTimestamp($newTimestamp);

        // Adjust result for time zone differences
        if ($tzOffset = $this->getOffsetForTimezone($date)) {
            $date->setTimestamp($newTimestamp + $tzOffset);
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