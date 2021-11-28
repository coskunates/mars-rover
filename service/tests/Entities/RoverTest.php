<?php

namespace Entities;

use App\Entities\Rover;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Entities\Rover
 * Class RoverTest
 */
class RoverTest extends TestCase
{
    /**
     * @covers \App\Entities\Rover::setId
     * @covers \App\Entities\Rover::getId
     * @covers \App\Entities\Rover::setPlateauId
     * @covers \App\Entities\Rover::getPlateauId
     * @covers \App\Entities\Rover::setX
     * @covers \App\Entities\Rover::getX
     * @covers \App\Entities\Rover::setY
     * @covers \App\Entities\Rover::getY
     * @covers \App\Entities\Rover::setDirection
     * @covers \App\Entities\Rover::getDirection
     */
    public function testGetterSetter()
    {
        $rover = new Rover();
        $rover->setId(1);
        $rover->setPlateauId(2);
        $rover->setX(3);
        $rover->setY(4);
        $rover->setDirection('N');

        $this->assertEquals(1, $rover->getId());
        $this->assertEquals(2, $rover->getPlateauId());
        $this->assertEquals(3, $rover->getX());
        $this->assertEquals(4, $rover->getY());
        $this->assertEquals('N', $rover->getDirection());
    }

    /**
     * @covers \App\Entities\Rover::setAttribute
     * @covers \App\Entities\Rover::getAttribute
     */
    public function testGetAttributeSetAttribute()
    {
        $rover = new Rover();
        $rover->setAttribute('x', 1);

        $this->assertEquals(1, $rover->getAttribute('x'));
    }
}