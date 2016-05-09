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
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        $dateTime = new \DateTime($date);

        // Current timestamp
        $timestamp = (int)$dateTime->format('U');

        // Calculate distance to next isochronic timestamp
        $isochronicOffset = $this->getIsochronicOffset($dateTime);
        $incrementBy = $this->referenceOffset - $isochronicOffset;
        if ($this->referenceOffset <= $isochronicOffset) {
            $incrementBy += $this->interval;
        }

        // Calculate new timestamp
        $dateTime->setTimestamp($timestamp + $incrementBy);

        return $dateTime->format('Y-m-d');
    }
}
