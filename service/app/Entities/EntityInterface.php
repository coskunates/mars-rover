<?php

namespace App\Entities;

/**
 * Interface EntityInterface
 * @package App\Entities
 */
interface EntityInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     */
    public function setId(int $id): void;

    /**
     * @param string $attributeName
     * @return mixed
     */
    public function getAttribute(string $attributeName): mixed;

    /**
     * @param string $attributeName
     * @param mixed $value
     */
    public function setAttribute(string $attributeName, mixed $value): void;
}