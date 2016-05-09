<?php
/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package
 * @subpackage
 */

namespace COG\ChronoShifter\Shifter;

use COG\ChronoShifter\Date\DateDecorator;
use COG\ChronoShifter\Date\HolidayProvider;

/**
 * Increments to next matching next first non-holiday weekday (M-F) of month
 *
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Shifter\Domain
 */
class MonthlyFirstWorkdayIncrement implements Shifter
{
    /**
     * @var \COG\ChronoShifter\Date\HolidayProvider
     */
    private $holidayProvider;

    /**
     * @param HolidayProvider $provider
     */
    public function __construct(HolidayProvider $provider)
    {
        $this->holidayProvider = $provider;
    }

    /**
     * @param string $date
     * @return string
     */
    public function shift($date)
    {
        if (!$this->holidayProvider instanceof HolidayProvider) {
            throw new \LogicException('Holiday provider required');
        }

        $dateDecorator = new DateDecorator(new \DateTime($date));
        $dateDecorator->setHolidayProvider($this->holidayProvider);
        $dayOfMonth = $dateDecorator->getDayOfMonth();
        $dateDecorator->toFirstWorkday();
        if ($dateDecorator->getDayOfMonth() <= $dayOfMonth) {
            $dateDecorator->addMonth()->toFirstWorkday();
        }

        return $dateDecorator->getDateTime()->format('Y-m-d');
    }
}
