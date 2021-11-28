<?php

namespace App\Repositories;

use App\Entities\EntityInterface;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @return EntityInterface
     */
    public function findOne(int $id): EntityInterface;

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     */
    public function save(EntityInterface $entity): EntityInterface;

    /**
     * @param EntityInterface $entity
     * @return EntityInterface
     */
    public function update(EntityInterface $entity): EntityInterface;
}