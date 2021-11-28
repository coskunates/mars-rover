<?php

namespace App\Repositories;

use App\Entities\EntityInterface;
use App\Entities\Plateau;
use App\Exceptions\NoRecordException;
use App\Exceptions\ValidationException;
use App\System\App;
use App\System\Message;

/**
 * Class PlateauRepository
 * @package App\Repositories
 */
class PlateauRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @var string $tableName
     */
    protected string $tableName = 'plateaus';

    /**
     * @param int $id
     * @return Plateau
     */
    public function findOne(int $id): Plateau
    {
        $query = App::db()->prepare('SELECT * FROM ' . $this->getTableName() . ' WHERE id = :id LIMIT 1');
        $query->bindParam(':id', $id);
        $query->execute();

        /** @var Plateau $result */
        $result = $query->fetchObject('App\Entities\Plateau');
        if (!$result instanceof Plateau) {
            throw new NoRecordException(
                sprintf(Message::get('general.not_found_id'), Message::get('general.plateau'), $id),
                1
            );
        }

        return $result;
    }

    /**
     * @param EntityInterface $entity
     * @return Plateau
     */
    public function save(EntityInterface $entity): Plateau
    {
        /** @var Plateau $entity */
        $this->validate($entity);

        $sql = 'INSERT INTO ' . $this->getTableName() . ' VALUES (NULL, :upper_bound_x, :upper_bound_y)';
        App::db()->prepare($sql)->execute((array)$entity);

        $entity->setId(App::db()->lastInsertId());

        return $entity;
    }

    /**
     * @param EntityInterface $entity
     * @return Plateau
     */
    public function update(EntityInterface $entity): Plateau
    {
        /** @var Plateau $entity */
        return $entity;
    }

    /**
     * @param EntityInterface $entity
     */
    protected function validate(EntityInterface $entity): void
    {
        if (empty($entity->getAttribute('upper_bound_x'))) {
            throw new ValidationException(
                sprintf(Message::get('validation.required'), Message::get('general.upper_bound_x')),
                2
            );
        }

        if (!is_numeric($entity->getAttribute('upper_bound_x')) || $entity->getAttribute('upper_bound_x') <= 0) {
            throw new ValidationException(
                sprintf(Message::get('validation.numeric_or_min'), Message::get('general.upper_bound_x'), 1),
                3
            );
        }

        if (empty($entity->getAttribute('upper_bound_y'))) {
            throw new ValidationException(
                sprintf(Message::get('validation.required'), Message::get('general.upper_bound_y')),
                4
            );
        }

        if (!is_numeric($entity->getAttribute('upper_bound_y')) || $entity->getAttribute('upper_bound_y') <= 0) {
            throw new ValidationException(
                sprintf(Message::get('validation.numeric_or_min'), Message::get('general.upper_bound_y'), 1),
                5
            );
        }
    }
}