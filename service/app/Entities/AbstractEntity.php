<?php

namespace App\Entities;

/**
 * Class AbstractEntity
 * @package App\Entities
 */
abstract class AbstractEntity
{
    /**
     * @param string $attributeName
     * @return mixed
     */
    public function getAttribute(string $attributeName): mixed
    {
        return $this->{$attributeName};
    }

    /**
     * @param string $attributeName
     * @param mixed $value
     */
    public function setAttribute(string $attributeName, mixed $value): void
    {
        $this->{$attributeName} = $value;
    }
}