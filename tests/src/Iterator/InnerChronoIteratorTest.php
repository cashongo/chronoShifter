<?php

namespace Tests\COG\Iterator\InnerShifter;

use COG\ChronoShifter\Iterator\InnerChronoIterator;

/**
 * @author Kristjan Siimson <kristjan.siimson@cashongo.co.uk>
 * @package Iterator\Test
 */
class InnerShifterTest extends \PHPUnit_Framework_TestCase
{
    public function testCurrentValuePassesValueFromInnerShifterToOuterShifter()
    {
        $innerShifter = $this->mockShifter();
        $innerShifter->expects($this->any())->method('shift')->will($this->returnValue('2015-01-02'));

        $outerShifter = $this->mockShifter();
        $outerShifter->expects($this->once())->method('shift')->with('2015-01-02');

        $iterator = new InnerChronoIterator($innerShifter, $outerShifter, '2011-11-11');
        $iterator->next();
        $iterator->current();
    }

    public function testNextReturnsValueFromOuterShifter()
    {
        $innerShifter = $this->mockShifter();

        $outerShifter = $this->mockShifter();
        $outerShifter->expects($this->once())->method('shift')->will($this->returnValue('2015-02-02'));

        $iterator = new InnerChronoIterator($innerShifter, $outerShifter, '2011-11-11');
        $iterator->next();
        $this->assertEquals('2015-02-02', $iterator->current());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function mockShifter()
    {
        return $this
            ->getMockBuilder('COG\ChronoShifter\Shifter\Shifter')
            ->setMethods(array('shift'))
            ->getMockForAbstractClass();
    }
}
