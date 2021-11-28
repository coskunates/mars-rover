<?php

namespace App\Controllers;

use App\Entities\Rover;
use App\Libraries\MarsRover\MarsRover;
use App\Repositories\PlateauRepository;
use App\Repositories\RoverRepository;
use App\System\App;
use App\System\Response\HTTPStatusCodes;
use App\System\Response;

/**
 * Class RoverController
 * @package App\Controllers
 */
class RoverController extends Controller
{
    /**
     * Gets the rover by id
     *
     * @param int $id
     * @return Response
     */
    public function get(int $id): Response
    {
        $data = [];

        $roverRepository = new RoverRepository();
        $rover = $roverRepository->findOne($id);
        if (!empty($rover)) {
            $plateauRepository = new PlateauRepository();
            $plateau = $plateauRepository->findOne($rover->getPlateauId());

            $data = (array)$rover;
            $data['plateau'] = $plateau;
        }

        return App::response()
            ->setStatusCode(HTTPStatusCodes::HTTP_OK)
            ->setData($data);
    }

    /**
     * Stores te plateau
     *
     * @return Response
     */
    public function store(): Response
    {
        $rover = new Rover();
        $rover->setPlateauId(App::request()->getParam('plateau_id'));
        $rover->setX(App::request()->getParam('x'));
        $rover->setY(App::request()->getParam('y'));
        $rover->setDirection(App::request()->getParam('direction'));

        $roverRepository = new RoverRepository();
        $roverRepository->save($rover);

        return App::response()
            ->setStatusCode(HTTPStatusCodes::HTTP_CREATED)
            ->setData((array)$rover);
    }

    /**
     * @param int $roverId
     * @return Response
     */
    public function move(int $roverId): Response
    {
        $roverRepository = new RoverRepository();
        $rover = $roverRepository->findOne($roverId);

        $plateauRepository = new PlateauRepository();
        $plateau = $plateauRepository->findOne($rover->getPlateauId());

        $commands = App::request()->getParam('commands');
        $commands = str_split($commands);

        $marsRoverObject = new MarsRover($commands, $plateau, $rover);
        $rover = $marsRoverObject->startMove();

        $roverRepository->update($rover);

        $result = [
            'x' => $rover->getX(),
            'y' => $rover->getY(),
            'direction' => $rover->getDirection()
        ];

        return App::response()
            ->setStatusCode(HTTPStatusCodes::HTTP_OK)
            ->setData($result);
    }

    /**
     * @param int $roverId
     * @return Response
     */
    public function state(int $roverId): Response
    {
        $roverRepository = new RoverRepository();
        $rover = $roverRepository->findOne($roverId);

        return App::response()
            ->setStatusCode(HTTPStatusCodes::HTTP_OK)
            ->setData((array)$rover);
    }
}