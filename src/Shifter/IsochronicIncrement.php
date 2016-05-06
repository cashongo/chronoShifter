<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increment date isochronically using a point of reference to first match on
 * the axis of time.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class IsochronicIncrement extends IsochronicShifter
{
    /**
     * @param \DateTime $date
     */
    public function shift(\DateTime $date)
    {
        // Ignore time
        $date->setTime(0, 0, 0);

        // Current timestamp
        $timestamp = (int)$date->format('U');

        // Calculate distance to next isochronic timestamp
        $isochronicOffset = $this->getIsochronicOffset($date);
        $incrementBy = $this->referenceOffset - $isochronicOffset;
        if ($this->referenceOffset <= $isochronicOffset) {
            $incrementBy += $this->interval;
        }

        // Calculate new timestamp
        $date->setTimestamp($timestamp + $incrementBy);
    }
}