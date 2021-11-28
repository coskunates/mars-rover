<?php

namespace App\Libraries\MarsRover\Commands;

use App\Entities\Plateau;
use App\Entities\Rover;

/**
 * Interface CommandInterface
 * @package App\Libraries\MarsRover\Commands
 */
interface CommandInterface
{
    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function run(Plateau $plateau, Rover $rover): Rover;
}