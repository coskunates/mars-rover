<?php

namespace App\Libraries\MarsRover\Directions;

use App\Entities\Plateau;
use App\Entities\Rover;
use App\Exceptions\MoveException;
use App\Libraries\MarsRover\Enums\DirectionEnums;
use App\System\Message;

/**
 * Class WestDirection
 * @package App\Libraries\MarsRover\Directions
 */
class WestDirection implements DirectionInterface
{
    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function turnLeft(Plateau $plateau, Rover $rover): Rover
    {
        $rover->setDirection(DirectionEnums::South->value);

        return $rover;
    }

    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function turnRight(Plateau $plateau, Rover $rover): Rover
    {
        $rover->setDirection(DirectionEnums::North->value);

        return $rover;
    }

    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function move(Plateau $plateau, Rover $rover): Rover
    {
        if ($rover->getX() - 1 < 0) {
            throw new MoveException(
                sprintf(
                    Message::get('error.rover_cant_move_min'),
                    DirectionEnums::West->name,
                    0
                ),
                15
            );
        }

        $rover->setX($rover->getX() - 1);

        return $rover;
    }
}