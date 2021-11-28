<?php

namespace App\Libraries\MarsRover;

use App\Entities\Plateau;
use App\Entities\Rover;
use App\Exceptions\MarsRoverException;
use App\Libraries\MarsRover\Enums\CommandEnums;

/**
 * class MarsRover
 * @package App\Libraries\MarsRover
 */
class MarsRover
{
    /**
     * @var array $commands
     */
    protected array $commands = [];

    /**
     * @var Plateau $plateau
     */
    protected Plateau $plateau;

    /**
     * @var Rover $rover
     */
    protected Rover $rover;

    /**
     * @param array $commands
     * @param Plateau $plateau
     * @param Rover $rover
     */
    public function __construct(array $commands, Plateau $plateau, Rover $rover)
    {
        $this->setCommands($commands);
        $this->setPlateau($plateau);
        $this->setRover($rover);
    }

    /**
     * @return Rover
     */
    public function startMove(): Rover
    {
        if (empty($this->getCommands())) {
            throw new MarsRoverException();
        }

        if (empty($this->getPlateau())) {
            throw new MarsRoverException();
        }

        if (empty($this->getRover())) {
            throw new MarsRoverException();
        }

        $invoker = new Invoker();

        foreach ($this->getCommands() as $command) {
            $this->setRover($invoker->run($command, $this->getPlateau(), $this->getRover()));
        }

        return $this->getRover();
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param array $commands
     */
    public function setCommands(array $commands): void
    {
        foreach ($commands as $command) {
            $this->commands[] = CommandEnums::from($command)->command();
        }
    }

    /**
     * @return Plateau
     */
    public function getPlateau(): Plateau
    {
        return $this->plateau;
    }

    /**
     * @param Plateau $plateau
     */
    public function setPlateau(Plateau $plateau): void
    {
        $this->plateau = $plateau;
    }

    /**
     * @return Rover
     */
    public function getRover(): Rover
    {
        return $this->rover;
    }

    /**
     * @param Rover $rover
     */
    public function setRover(Rover $rover): void
    {
        $this->rover = $rover;
    }
}