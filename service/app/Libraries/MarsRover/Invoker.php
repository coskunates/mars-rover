<?php

namespace App\Libraries\MarsRover;

use App\Entities\Plateau;
use App\Entities\Rover;
use App\Libraries\MarsRover\Commands\CommandInterface;

/**
 * class Invoker
 * @package App\Libraries\MarsRover
 */
class Invoker
{
    /**
     * @param CommandInterface $command
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function run(CommandInterface $command, Plateau $plateau, Rover $rover): Rover
    {
        return $command->run($plateau, $rover);
    }
}