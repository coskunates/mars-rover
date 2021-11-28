<?php

namespace Entities;

use App\Entities\Plateau;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Entities\Plateau
 * Class PlateauTest
 */
class PlateauTest extends TestCase
{
    /**
     * @covers \App\Entities\Plateau::setId
     * @covers \App\Entities\Plateau::getId
     * @covers \App\Entities\Plateau::setUpperBoundX
     * @covers \App\Entities\Plateau::getUpperBoundX
     * @covers \App\Entities\Plateau::setUpperBoundY
     * @covers \App\Entities\Plateau::getUpperBoundY
     */
    public function testGetterSetter()
    {
        $plateau = new Plateau();
        $plateau->setId(1);
        $plateau->setUpperBoundX(15);
        $plateau->setUpperBoundY(16);

        $this->assertEquals(1, $plateau->getId());
        $this->assertEquals(15, $plateau->getUpperBoundX());
        $this->assertEquals(16, $plateau->getUpperBoundY());
    }

    /**
     * @covers \App\Entities\Plateau::setAttribute
     * @covers \App\Entities\Plateau::getAttribute
     */
    public function testGetAttributeSetAttribute()
    {
        $plateau = new Plateau();
        $plateau->setAttribute('upper_bound_x', 1);

        $this->assertEquals(1, $plateau->getAttribute('upper_bound_x'));
    }
}