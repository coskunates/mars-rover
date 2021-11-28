<?php

namespace App\Entities;

/**
 * Class Rover
 * @package App\Entities
 */
class Rover extends AbstractEntity implements EntityInterface
{
    /**
     * @var int $id
     */
    public int $id;

    /**
     * Database fields are snake_case so defined as such
     * @var int $plateau_id
     */
    public int $plateau_id;

    /**
     * @var int $x
     */
    public int $x;

    /**
     * @var int $y
     */
    public int $y;

    /**
     * @var string $direction
     */
    public string $direction;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return int
     */
    public function getPlateauId(): int
    {
        return $this->plateau_id;
    }

    /**
     * @param int $plateau_id
     */
    public function setPlateauId(int $plateau_id): void
    {
        $this->plateau_id = $plateau_id;
    }
}