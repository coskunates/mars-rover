<?php

namespace App\Libraries\MarsRover\Enums;

use App\Libraries\MarsRover\Directions\DirectionInterface;
use App\Libraries\MarsRover\Directions\EastDirection;
use App\Libraries\MarsRover\Directions\NorthDirection;
use App\Libraries\MarsRover\Directions\SouthDirection;
use App\Libraries\MarsRover\Directions\WestDirection;

/**
 * enum DirectionEnums
 * @package App\Libraries\MarsRover\Enums
 */
enum DirectionEnums: string
{
    case North = 'N';
    case South = 'S';
    case East = 'E';
    case West = 'W';

    /**
     * @return DirectionInterface
     */
    public function directions(): DirectionInterface
    {
        return match ($this) {
            self::North => new NorthDirection(),
            self::South => new SouthDirection(),
            self::East => new EastDirection(),
            self::West => new WestDirection()
        };
    }
}