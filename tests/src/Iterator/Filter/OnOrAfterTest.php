<?php

namespace Tests\COG\Iterator\Filter\After;

use COG\ChronoShifter\Iterator\Filter\OnOrAfter;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Test
 */
class AfterOrEqualTest extends \PHPUnit_Framework_TestCase
{
    public function testOnlyDatesAfterAreAccepted()
    {
        $values = array('2011-01-01', '2011-01-01 23:59:59', '2011-01-02', '2011-01-02 23:59:59', '2011-01-03');
        $results = array();
        foreach (new OnOrAfter(new \ArrayIterator($values), '2011-01-02') as $date) {
            $results[] = $date;
        }

        $this->assertEquals(array('2011-01-02', '2011-01-02 23:59:59', '2011-01-03'), $results);
    }
}
