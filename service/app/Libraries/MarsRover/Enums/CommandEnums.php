<?php

namespace App\Libraries\MarsRover\Enums;

use App\Libraries\MarsRover\Commands\CommandInterface;
use App\Libraries\MarsRover\Commands\MoveCommand;
use App\Libraries\MarsRover\Commands\TurnLeftCommand;
use App\Libraries\MarsRover\Commands\TurnRightCommand;

/**
 * enum CommandEnums
 * @package App\Libraries\MarsRover\Enums
 */
enum CommandEnums: string
{
    case Left = 'L';
    case Right = 'R';
    case Move = 'M';

    /**
     * @return CommandInterface
     */
    public function command(): CommandInterface
    {
        return match ($this) {
            self::Left => new TurnLeftCommand(),
            self::Right => new TurnRightCommand(),
            self::Move => new MoveCommand(),
        };
    }
}