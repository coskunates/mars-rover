<?php

namespace App\Libraries\MarsRover\Directions;

use App\Entities\Plateau;
use App\Entities\Rover;

/**
 * Interface DirectionInterface
 * @package App\Libraries\MarsRover\Directions
 */
interface DirectionInterface
{
    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function turnRight(Plateau $plateau, Rover $rover): Rover;

    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function turnLeft(Plateau $plateau, Rover $rover): Rover;

    /**
     * @param Plateau $plateau
     * @param Rover $rover
     * @return Rover
     */
    public function move(Plateau $plateau, Rover $rover): Rover;
}