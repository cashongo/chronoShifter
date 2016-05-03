<?php

namespace COG\ChronoShifter\Date;

use LogicException;

/**
 * Internal date object wrapped around PHP \DateTime
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Date\Domain
 */
class DateDecorator
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
    public function __construct(\DateTime $date)
    {
        $this->setDateTime($date);
    }

    /**
     * @return \DateTime ISO8601
     */
    public function getDateTime()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDateTime(\DateTime $date)
    {
        $this->date = $date->setTime(0, 0, 0);
        
        return $this;
    }

    /**
     * @return int
     */
    public function getDayOfMonth()
    {
        return (int)$this->date->format('j');
    }

    /**
     * @param $day
     * @return $this
     */
    public function setDayOfMonth($day)
    {
        $this->date->setDate(
            $this->date->format('Y'),
            $this->date->format('n'),
            $day
        );

        return $this;
    }

    /**
     * @return bool
     * @throws LogicException If holiday provider not specified
     */
    public function isHoliday()
    {
        if (false === $this->holiday instanceof HolidayProvider) {
            throw new LogicException('Holiday provider required');
        }

        return $this->holiday->isHoliday($this->getDateTime());
    }

    /**
     * @return bool
     */
    public function isWeekday()
    {
        $dayOfWeek = (int)$this->date->format('N');
        return $dayOfWeek <= 5;
    }

    /**
     * @return HolidayProvider
     */
    public function getHolidayProvider()
    {
        return $this->holiday;
    }

    /**
     * @param HolidayProvider $provider
     * @return $this
     */
    public function setHolidayProvider(HolidayProvider $provider)
    {
        $this->holiday = $provider;

        return $this;
    }

    /**
     * @param $interval
     * @return $this
     */
    public function addInterval($interval)
    {
        $this->date->add(new \DateInterval($interval));

        return $this;
    }

    /**
     * @param $interval
     * @return $this
     */
    public function subtractInterval($interval)
    {
        $this->date->sub(new \DateInterval($interval));

        return $this;
    }

    /**
     * @return $this
     */
    public function addMonth()
    {
        $year = $this->date->format('Y');
        $month = (int)$this->date->format('n') + 1;
        if (13 === $month) {
            $month = 1;
            $year++;
        }
        $day = $this->date->format('j');
        $this->date->setDate($year, $month, 1);
        $this->date->setDate($year, $month, min($day, $this->getDaysInMonth()));

        return $this;
    }

    /**
     * @return $this
     */
    public function subtractMonth()
    {
        $year = $this->date->format('Y');
        $month = (int)$this->date->format('n') - 1;
        if (0 === $month) {
            $month = 12;
            $year--;
        }
        $day = $this->date->format('j');
        $this->date->setDate($year, $month, 1);
        $this->date->setDate($year, $month, min($day, $this->getDaysInMonth()));

        return $this;
    }

    /**
     * @return int
     */
    public function getDaysInMonth()
    {
        return (int)$this->date->format('t');
    }

    /**
     * @return $this
     */
    public function toFirstWorkday()
    {
        // Increment date until we have a banking day
        for ($dayOfMonth = 1; $dayOfMonth < $this->date->format('t'); $dayOfMonth++) {
            $this->setDayOfMonth($dayOfMonth);

            $bankingDay = $this->isWeekday() && !$this->isHoliday();

            if ($bankingDay) {
                break;
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function toLastWorkday()
    {
        // Decrement date until we have a banking day
        for ($dayOfMonth = $this->date->format('t'); $dayOfMonth >= 1 ; $dayOfMonth--) {
            $this->setDayOfMonth($dayOfMonth);

            $bankingDay = $this->isWeekday() && !$this->isHoliday();

            if ($bankingDay) {
                break;
            }
        }

        return $this;
    }
}