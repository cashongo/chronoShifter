<?php
/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package
 * @subpackage
 */

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\Date;
use COG\ChronoShifter\Date\HolidayProvider;

/**
 * Decrements to previous matching first non-holiday weekday (M-F) of month
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyFirstWorkdayDecrement {
    /**
     * @var \COG\ChronoShifter\Date\HolidayProvider
     */
    private $holidayProvider;

    /**
     * @param \DateTime $dateTime
     */
    public function shift(\DateTime $dateTime) {
        if(!$this->holidayProvider instanceof HolidayProvider) {
            throw new \LogicException('Holiday provider required');
        }

        $date = new Date($dateTime);
        $date->setHolidayProvider($this->holidayProvider);
        $dayOfMonth = (int)$dateTime->format('j');

        $this->toFirstWorkday($date);

        if ($date->getDayOfMonth() >= $dayOfMonth) {
            $date->subtractInterval(Date::INTERVAL_ONE_MONTH);
            $this->toFirstWorkday($date);
        }
    }

    /**
     * @return HolidayProvider
     */
    public function getHolidayProvider() {
        return $this->holidayProvider;
    }

    /**
     * @param HolidayProvider $provider
     */
    public function setHolidayProvider(HolidayProvider $provider) {
        $this->holidayProvider = $provider;
    }

    /**
     * @param Date $date
     */
    private function toFirstWorkday(Date $date) {
        // Increment date until we have a banking day
        for ($dayOfMonth = 1; $dayOfMonth < 30; $dayOfMonth++) {
            $date->setDayOfMonth($dayOfMonth);

            $bankingDay = $date->isWeekday() && !$date->isHoliday();

            if ($bankingDay) {
                break;
            }
        }
    }
}