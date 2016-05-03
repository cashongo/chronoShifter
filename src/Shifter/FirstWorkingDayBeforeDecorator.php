<?php
namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\DateDecorator;
use COG\ChronoShifter\Date\HolidayProvider;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class FirstWorkingDayBeforeDecorator implements Shifter
{
    /**
     * @var Shifter
     */
    private $shifter;

    /**
     * @var HolidayProvider
     */
    private $holidayProvider;

    /**
     * @param Shifter $shifter
     * @param HolidayProvider $holidayProvider
     */
    public function __construct(Shifter $shifter, HolidayProvider $holidayProvider)
    {
        $this->shifter = $shifter;
        $this->holidayProvider = $holidayProvider;
    }

    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    public function shift(\DateTime $dateTime)
    {
        $this->shifter->shift($dateTime);
        $result = new DateDecorator($dateTime);
        $result->setHolidayProvider($this->holidayProvider);
        $dateTime->setTimestamp($result->decrementToWorkday()->getDateTime()->getTimestamp());
    }
}
