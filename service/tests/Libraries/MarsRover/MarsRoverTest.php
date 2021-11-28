<?php

namespace Libraries\MarsRover;

use App\Entities\Plateau;
use App\Entities\Rover;
use App\Exceptions\MoveException;
use App\Libraries\MarsRover\MarsRover;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass  \App\Libraries\MarsRover\MarsRover
 * Class MarsRoverTest
 */
class MarsRoverTest extends TestCase
{
    /**
     * @covers \App\Libraries\MarsRover\MarsRover::startMove
     * @covers \App\Libraries\MarsRover\MarsRover::setRover
     * @covers \App\Libraries\MarsRover\MarsRover::setPlateau
     * @covers \App\Libraries\MarsRover\MarsRover::setCommands
     */
    public function testStartMoveSuccess()
    {
        $plateau = new Plateau();
        $plateau->setId(1);
        $plateau->setUpperBoundX(5);
        $plateau->setUpperBoundY(5);

        $rover = new Rover();
        $rover->setPlateauId(1);
        $rover->setX(1);
        $rover->setY(2);
        $rover->setDirection('N');

        $command = 'LMLMLMLMM';
        $commands = str_split($command);
        $marsRover = new MarsRover($commands, $plateau, $rover);
        $rover = $marsRover->startMove();

        $this->assertEquals(1, $rover->getX());
        $this->assertEquals(3, $rover->getY());
        $this->assertEquals('N', $rover->getDirection());
    }

    /**
     * @covers \App\Libraries\MarsRover\MarsRover::startMove
     * @covers \App\Libraries\MarsRover\MarsRover::setRover
     * @covers \App\Libraries\MarsRover\MarsRover::setPlateau
     * @covers \App\Libraries\MarsRover\MarsRover::setCommands
     */
    public function testStartMoveOutOfMaximumLimits()
    {
        $this->expectException(MoveException::class);
        $plateau = new Plateau();
        $plateau->setId(1);
        $plateau->setUpperBoundX(5);
        $plateau->setUpperBoundY(5);

        $rover = new Rover();
        $rover->setPlateauId(1);
        $rover->setX(1);
        $rover->setY(2);
        $rover->setDirection('N');

        $command = 'MMMMMMM';
        $commands = str_split($command);
        $marsRover = new MarsRover($commands, $plateau, $rover);
        $marsRover->startMove();
    }

    /**
     * @covers \App\Libraries\MarsRover\MarsRover::startMove
     * @covers \App\Libraries\MarsRover\MarsRover::setRover
     * @covers \App\Libraries\MarsRover\MarsRover::setPlateau
     * @covers \App\Libraries\MarsRover\MarsRover::setCommands
     */
    public function testStartMoveOutOfMinimumLimits()
    {
        $this->expectException(MoveException::class);
        $plateau = new Plateau();
        $plateau->setId(1);
        $plateau->setUpperBoundX(5);
        $plateau->setUpperBoundY(5);

        $rover = new Rover();
        $rover->setPlateauId(1);
        $rover->setX(1);
        $rover->setY(2);
        $rover->setDirection('S');

        $command = 'MMMMMMM';
        $commands = str_split($command);
        $marsRover = new MarsRover($commands, $plateau, $rover);
        $marsRover->startMove();
    }
}