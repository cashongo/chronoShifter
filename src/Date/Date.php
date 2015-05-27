<?php

namespace COG\ChronoShifter\Date;

use LogicException;

/**
 * Internal date object wrapped around PHP \DateTime
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package COG\ChronoShifter
 * @subpackage Date
 */
class Date
{
    const INTERVAL_ONE_MONTH = 'P1M';

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var HolidayProvider
     */
    private $holiday;

    /**
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date) {
        $this->setDateTime($date);
    }

    /**
     * @return \DateTime ISO8601
     */
    public function getDateTime() {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDateTime(\DateTime $date) {
        $this->date = $date->setTime(0, 0, 0);
    }

    /**
     * @return int
     */
    public function getDayOfMonth() {
        return (int) $this->date->format('j');
    }

    /**
     * @param $day
     */
    public function setDayOfMonth($day) {
        $this->date->setDate(
            $this->date->format('Y'),
            $this->date->format('n'),
            $day
        );
    }

    /**
     * @return bool
     * @throws LogicException If holiday provider not specified
     */
    public function isHoliday() {
        if(false === $this->holiday instanceof HolidayProvider) {
            throw new LogicException('Holiday provider required');
        }

        return $this->holiday->isHoliday($this->getDateTime());
    }

    /**
     * @return bool
     */
    public function isWeekday() {
        $dayOfWeek = (int) $this->date->format('N');
        return $dayOfWeek <= 5;
    }

    /**
     * @return HolidayProvider
     */
    public function getHolidayProvider() {
        return $this->holiday;
    }

    /**
     * @param HolidayProvider $provider
     */
    public function setHolidayProvider(HolidayProvider $provider) {
        $this->holiday = $provider;
    }

    /**
     * @param $interval
     */
    public function addInterval($interval) {
        $this->date->add(new \DateInterval($interval));
    }

    /**
     * @param $interval
     */
    public function subtractInterval($interval) {
        $this->date->sub(new \DateInterval($interval));
    }
}
