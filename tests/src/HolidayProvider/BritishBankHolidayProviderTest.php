<?php

namespace Tests\COG\ChronoShifter\Date;

use COG\ChronoShifter\HolidayProvider\BritishBankHolidayProvider;
use PHPUnit_Framework_TestCase;

/**
 *
 * @package Tests\COG\ChronoShifter\Date
 * @author Sergei Gorjunov <sergei.gorjunov@cashongo.co.uk>
 */
class BritishBankHolidayProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Date "myInvalidDate" is not in format "Y-m-d"
     */
    public function testIsHolidayInvalidDateThrowsException()
    {
        $provider = new BritishBankHolidayProvider();
        $provider->isHoliday('myInvalidDate');
    }

    /**
     * @dataProvider isHolidayDataProvider
     * @param string $date
     * @param bool $expectedResult
     */
    public function testIsHoliday($date, $expectedResult)
    {
        $provider = new BritishBankHolidayProvider();
        self::assertEquals($expectedResult, $provider->isHoliday($date));
    }

    /**
     * @return array
     */
    public function isHolidayDataProvider()
    {
        return [
            ['2019-01-01', true],
            ['2019-01-02', false],
            ['2019-04-18', false],
            ['2019-04-19', true],
            ['2019-04-20', false],
            ['2019-04-21', true],
            ['2019-04-22', true],
            ['2019-04-23', false],
            ['2019-05-05', false],
            ['2019-05-06', true],
            ['2019-05-07', false],
            ['2019-05-26', false],
            ['2019-05-27', true],
            ['2019-05-28', false],
            ['2019-08-25', false],
            ['2019-08-26', true],
            ['2019-08-27', false],
            ['2019-12-23', false],
            ['2019-12-24', false],
            ['2019-12-25', true],
            ['2019-12-26', true],
            ['2019-12-27', false],
            ['2020-01-01', true],
            ['2020-04-10', true],
            ['2020-04-12', true],
            ['2020-04-13', true],
            ['2020-04-19', false],
            ['2020-04-21', false],
            ['2020-04-22', false],
            ['2020-05-04', true],
            ['2020-05-06', false],
            ['2020-05-25', true],
            ['2020-05-27', false],
            ['2020-08-26', false],
            ['2020-08-31', true],
            ['2020-12-25', true],
            ['2020-12-26', true],
        ];
    }
}
