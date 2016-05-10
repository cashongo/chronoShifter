<?php

namespace COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\HolidayProvider\HolidayProvider;

/**
 * @package Evaluator\Domain
 */
class Workday extends LogicalAnd
{
    /**
     * @param HolidayProvider $holidayProvider
     */
    public function __construct(HolidayProvider $holidayProvider)
    {
        parent::__construct(new Weekday(), new LogicalNot(new Holiday($holidayProvider)));
    }
}
