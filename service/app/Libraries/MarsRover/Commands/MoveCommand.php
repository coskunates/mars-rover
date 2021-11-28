<?php

namespace App\Libraries\MarsRover\Commands;

use App\Entities\Plateau;
use App\Entities\Rover;
use App\Libraries\MarsRover\Enums\DirectionEnums;

/**
 * Class MoveCommand
 * @package App\Libraries\MarsRover\Commands
 */
class MoveCommand implements CommandInterface
{
    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function run(Plateau $plateau, Rover $rover): Rover
    {
        $direction = DirectionEnums::from($rover->getDirection())->directions();

        return $direction->move($plateau, $rover);
    }
}