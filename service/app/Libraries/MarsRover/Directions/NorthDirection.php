<?php

namespace App\Libraries\MarsRover\Directions;

use App\Entities\Plateau;
use App\Entities\Rover;
use App\Exceptions\MoveException;
use App\Libraries\MarsRover\Enums\DirectionEnums;
use App\System\Message;

/**
 * Class NorthDirection
 * @package App\Libraries\MarsRover\Directions
 */
class NorthDirection implements DirectionInterface
{
    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function turnLeft(Plateau $plateau, Rover $rover): Rover
    {
        $rover->setDirection(DirectionEnums::West->value);

        return $rover;
    }

    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function turnRight(Plateau $plateau, Rover $rover): Rover
    {
        $rover->setDirection(DirectionEnums::East->value);

        return $rover;
    }

    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function move(Plateau $plateau, Rover $rover): Rover
    {
        if ($rover->getY() + 1 > $plateau->getUpperBoundY()) {
            throw new MoveException(
                sprintf(
                    Message::get('error.rover_cant_move_max'),
                    DirectionEnums::North->name,
                    $plateau->getUpperBoundY()
                ),
                14
            );
        }

        $rover->setY($rover->getY() + 1);

        return $rover;
    }
}