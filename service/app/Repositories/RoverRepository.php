<?php

namespace App\Repositories;

use App\Entities\EntityInterface;
use App\Entities\Rover;
use App\Exceptions\NoRecordException;
use App\Exceptions\ValidationException;
use App\Libraries\MarsRover\Enums\DirectionEnums;
use App\System\App;
use App\System\Message;

/**
 * Class RoverRepository
 * @package App\Repositories
 */
class RoverRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * @var string $tableName
     */
    protected string $tableName = 'rovers';

    /**
     * @param int $id
     * @return Rover
     */
    public function findOne(int $id): Rover
    {
        $query = App::db()->prepare('SELECT * FROM ' . $this->getTableName() . ' WHERE id = :id LIMIT 1');
        $query->bindParam(':id', $id);
        $query->execute();

        /** @var Rover $result */
        $result = $query->fetchObject('App\Entities\Rover');
        if (!$result instanceof Rover) {
            throw new NoRecordException(
                sprintf(Message::get('general.not_found_id'), Message::get('general.rover'), $id),
                6
            );
        }

        return $result;
    }

    /**
     * @param EntityInterface $entity
     * @return Rover
     */
    public function save(EntityInterface $entity): Rover
    {
        /** @var Rover $entity */
        $this->validate($entity);

        $sql = 'INSERT INTO ' . $this->getTableName() . ' VALUES (NULL, :plateau_id, :x, :y, :direction)';
        App::db()->prepare($sql)->execute((array)$entity);

        $entity->setId(App::db()->lastInsertId());

        return $entity;
    }

    /**
     * @param EntityInterface $entity
     * @return Rover
     */
    public function update(EntityInterface $entity): Rover
    {
        /** @var Rover $entity */

        $sql = 'UPDATE ' . $this->getTableName() . ' 
        SET 
            plateau_id=:plateau_id, 
            x=:x, 
            y=:y, 
            direction=:direction 
        WHERE 
        id=:id';

        App::db()->prepare($sql)->execute((array)$entity);

        return $entity;
    }

    /**
     * @param EntityInterface $entity
     */
    protected function validate(EntityInterface $entity): void
    {
        $plateauRepository = new PlateauRepository();
        $plateau = $plateauRepository->findOne($entity->getAttribute('plateau_id'));

        if (!is_numeric($entity->getAttribute('x')) || $entity->getAttribute('x') < 0) {
            throw new ValidationException(
                sprintf(Message::get('validation.numeric_or_min'), 'x', 0),
                7
            );
        }

        if ($entity->getAttribute('x') > $plateau->getUpperBoundX()) {
            throw new ValidationException(
                sprintf(
                    Message::get('validation.out_of_bounds'),
                    Message::get('general.rover'),
                    'x',
                    $entity->getAttribute('x'),
                    $plateau->getUpperBoundX()
                ),
                8
            );
        }

        if (!is_numeric($entity->getAttribute('y')) || $entity->getAttribute('y') < 0) {
            throw new ValidationException(
                sprintf(Message::get('validation.numeric_or_min'), 'y', 0),
                10
            );
        }

        if ($entity->getAttribute('y') > $plateau->getUpperBoundY()) {
            throw new ValidationException(
                sprintf(
                    Message::get('validation.out_of_bounds'),
                    Message::get('general.rover'),
                    'y',
                    $entity->getAttribute('y'),
                    $plateau->getUpperBoundY()
                ),
                11
            );
        }

        if (empty($entity->getAttribute('direction'))) {
            throw new ValidationException(
                sprintf(Message::get('validation.required'), 'x'),
                12
            );
        }

        if (empty(DirectionEnums::tryFrom($entity->getAttribute('direction')))){
            throw new ValidationException(
                sprintf(Message::get('validation.invalid'), Message::get('general.direction')),
                13
            );
        }
    }
}