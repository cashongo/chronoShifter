<?php

namespace COG\ChronoShifter\Shifter;

/**
 * Increment date isochronically using a point of reference to first match on
 * the axis of time.
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Shifter
 */
class IsochronicIncrement extends IsochronicShifter
{
    /**
     * @param \DateTime $time
     */
    public function shift(\DateTime $time) {
        $time->setTime(0, 0, 0);

        $timestamp = (int) $time->format('U');

        $offset = $this->getIsochronicOffset($time);

        $incrementBy = $this->referenceOffset - $offset;

        if ($this->referenceOffset <= $offset) {
            $incrementBy += $this->interval;
        }

        $time->setTimestamp($timestamp + $incrementBy);
    }
}