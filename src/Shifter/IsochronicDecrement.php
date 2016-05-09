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
    /**
     * @var int
     */
    private $initTzOffset;

    /**
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        $dateTime = new \DateTime($date);

        // Ignore time
        $dateTime->setTime(0, 0, 0);

        // Current timestamp
        $timestamp = (int)$dateTime->format('U');

        // Store current timezone offset
        $this->calculateInitialTimezoneOffset($dateTime);

        // Calculate distance to previous isochronic timestamp
        $isochronicOffset = $this->getIsochronicOffset($dateTime);
        $decrementBy = $isochronicOffset - $this->referenceOffset;
        if ($this->referenceOffset >= $isochronicOffset) {
            $decrementBy += $this->interval;
        }

        // Calculate new timestamp
        $newTimestamp = $timestamp - $decrementBy;
        $dateTime->setTimestamp($newTimestamp);

        // Adjust result for time zone differences
        if ($tzOffset = $this->getOffsetForTimezone($dateTime)) {
            $dateTime->setTimestamp($newTimestamp + $tzOffset);
        }

        return $dateTime->format('Y-m-d');
    }

    /**
     * @param \DateTime $time
     */
    private function calculateInitialTimezoneOffset(\DateTime $time)
    {
        $this->initTzOffset = $time->getTimezone()->getOffset($time);
    }

    /**
     * @param \DateTime $time
     * @return int
     */
    private function getOffsetForTimezone(\DateTime $time)
    {
        $finalOffset = $time->getTimezone()->getOffset($time);
        return ($this->initTzOffset - $finalOffset);
    }
}