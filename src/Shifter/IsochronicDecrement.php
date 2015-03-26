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
    /**
     * @param \DateTime $time
     */
    public function shift(\DateTime $time) {
        $time->setTime(0, 0, 0);

        $timestamp = (int) $time->format('U');
        $offset = $this->getIsochronicOffset($time);

        $decrementBy = $offset - $this->referenceOffset;

        if ($this->referenceOffset >= $offset) {
            $decrementBy += $this->interval;
        }

        $time->setTimestamp($timestamp - $decrementBy);
    }
}