<?php

namespace App\Entities;

/**
 * Class Plateau
 * @package App\Entities
 */
class Plateau extends AbstractEntity implements EntityInterface
{
    /**
     * @var int $id
     */
    public int $id;

    /**
     * @var int $upper_bound_x
     */
    public int $upper_bound_x;

    /**
     * @var int $upper_bound_y
     */
    public int $upper_bound_y;

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
    public function getUpperBoundX(): int
    {
        return $this->upper_bound_x;
    }

    /**
     * @param int $upper_bound_x
     */
    public function setUpperBoundX(int $upper_bound_x): void
    {
        $this->upper_bound_x = $upper_bound_x;
    }

    /**
     * @return int
     */
    public function getUpperBoundY(): int
    {
        return $this->upper_bound_y;
    }

    /**
     * @param int $upper_bound_y
     */
    public function setUpperBoundY(int $upper_bound_y): void
    {
        $this->upper_bound_y = $upper_bound_y;
    }
}