<?php

namespace App\Libraries\MarsRover\Commands;

use App\Entities\Plateau;
use App\Entities\Rover;
use App\Libraries\MarsRover\Enums\DirectionEnums;

/**
 * Class TurnLeftCommand
 * @package App\Libraries\MarsRover\Commands
 */
class TurnLeftCommand implements CommandInterface
{
    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function run(Plateau $plateau, Rover $rover): Rover
    {
        $direction = DirectionEnums::from($rover->getDirection())->directions();

        return $direction->turnLeft($plateau, $rover);
    }
}