<?php

namespace Tests\COG\ChronoShifter\Evaluator;

use COG\ChronoShifter\HolidayProvider\ArrayHolidayProvider;
use COG\ChronoShifter\Evaluator\Holiday;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Evaluator\Tests
 */
class HolidayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayHolidayProvider
     */
    private $holidayProvider;

    public function setUp()
    {
        $this->holidayProvider = new ArrayHolidayProvider(array('2010-01-01'));
    }

    public function testHolidayReturnsTrue()
    {
        $evaluator = new Holiday($this->holidayProvider);
        $this->assertTrue($evaluator->is('2010-01-01'));
    }

    public function testNonHolidayReturnsFalse()
    {
        $evaluator = new Holiday($this->holidayProvider);
        $this->assertFalse($evaluator->is('2010-01-02'));
    }
}
