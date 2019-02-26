<?php

namespace COG\ChronoShifter\HolidayProvider;

use DateTime;
use InvalidArgumentException;

/**
 *
 * @package COG\ChronoShifter\HolidayProvider
 * @author Sergei Gorjunov <sergei.gorjunov@cashongo.co.uk>
 */
class BritishBankHolidayProvider implements HolidayProvider
{
    /**
     * @inheritDoc
     */
    public function isHoliday($date)
    {
        $checkDate = DateTime::createFromFormat('Y-m-d', $date);
        if (!$checkDate instanceof DateTime) {
            throw new InvalidArgumentException(sprintf('Date "%s" is not in format "Y-m-d"', $date));
        }

        $result = false;
        foreach ($this->getHolidaysByYear($checkDate->format('Y')) as $holiday) {
            if ($checkDate->format('Ymd') === $holiday->format('Ymd')) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * @param int $year
     * @return DateTime[]
     */
    private function getHolidaysByYear($year)
    {
        return [
            $this->getNewYearDate($year),
            $this->getGoodFridayDate($year),
            $this->getEasterSundayDate($year),
            $this->getEasterMondayDate($year),
            $this->getMayDay($year),
            $this->getSpringBankHoliday($year),
            $this->getSummerBankHoliday($year),
            $this->getChristmasDay($year),
            $this->getStephensDay($year)
        ];
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getEasterSundayDate($year)
    {
        $result = (new DateTime())->setDate($year, 3, 21)->setTime(0, 0);
        $result->modify(sprintf('+%d days', easter_days($year)));

        return $result;
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getGoodFridayDate($year)
    {
        $goodFriday = clone $this->getEasterSundayDate($year);
        $goodFriday->modify('-2 days');

        return $goodFriday;
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getEasterMondayDate($year)
    {
        $easterMonday = clone $this->getEasterSundayDate($year);
        $easterMonday->modify('+1 day');

        return $easterMonday;
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getMayDay($year)
    {
        return (new DateTime())->setDate($year, 5, 1)->setTime(0, 0)->modify('first Monday of this month');
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getSpringBankHoliday($year)
    {
        return (new DateTime())->setDate($year, 5, 1)->setTime(0, 0)->modify('last Monday of this month');
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getSummerBankHoliday($year)
    {
        return (new DateTime())->setDate($year, 8, 1)->setTime(0, 0)->modify('last Monday of this month');
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getAscensionDate($year)
    {
        $ascensionDate = $this->getEasterSundayDate($year);
        $ascensionDate->modify('+39 days');

        return $ascensionDate;
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getPentecostDate($year)
    {
        $ascensionDate = $this->getEasterSundayDate($year);
        $ascensionDate->modify('+49 days');

        return $ascensionDate;
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getChristmasDay($year)
    {
        return (new DateTime())->setDate($year, 12, 25)->setTime(0, 0);
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getStephensDay($year)
    {
        return (new DateTime())->setDate($year, 12, 26)->setTime(0, 0);
    }

    /**
     * @param int $year
     * @return DateTime
     */
    private function getNewYearDate($year)
    {
        return (new DateTime())->setDate($year, 1, 1)->setTime(0, 0);
    }
}
