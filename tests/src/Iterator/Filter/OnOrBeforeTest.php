<?php

namespace Tests\COG\Iterator\Filter\After;

use COG\ChronoShifter\Iterator\Filter\OnOrBefore;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Test
 */
class OnOrBeforeTest extends \PHPUnit_Framework_TestCase
{
    public function testOnlyDatesBeforeAreAccepted()
    {
        $values = array('2011-01-01', '2011-01-01 23:59:59', '2011-01-02', '2011-01-02 23:59:59', '2011-01-03');
        $results = array();
        foreach (new OnOrBefore(new \ArrayIterator($values), '2011-01-02') as $date) {
            $results[] = $date;
        }

        $this->assertEquals(array('2011-01-01', '2011-01-01 23:59:59', '2011-01-02', '2011-01-02 23:59:59'), $results);
    }
}
