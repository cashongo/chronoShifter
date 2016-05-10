<?php

namespace COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\HolidayProvider\HolidayProvider;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Domain
 */
class Holiday implements Evaluator
{
    /**
     * @var HolidayProvider
     */
    private $holidayProvider;

    /**
     * @param HolidayProvider $holidayProvider
     */
    public function __construct(HolidayProvider $holidayProvider)
    {
        $this->holidayProvider = $holidayProvider;
    }

    /**
     * @param string $date
     * @return bool
     */
    public function is($date)
    {
        return $this->holidayProvider->isHoliday($date);
    }
}
