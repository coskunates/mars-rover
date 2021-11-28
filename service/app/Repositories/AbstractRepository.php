<?php

namespace App\Repositories;

use App\Entities\EntityInterface;

/**
 * Abstract Class AbstractRepository
 * @package App\Repositories
 */
abstract class AbstractRepository
{
    /**
     * @var string $tableName
     */
    protected string $tableName = '';

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param EntityInterface $entity
     */
    abstract protected function validate(EntityInterface $entity): void;
}