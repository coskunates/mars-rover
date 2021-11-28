<?php

namespace App\Controllers;

use App\Entities\Plateau;
use App\Repositories\PlateauRepository;
use App\System\App;
use App\System\Response\HTTPStatusCodes;
use App\System\Response;

/**
 * Class PlateauController
 * @package App\Controllers
 */
class PlateauController extends Controller
{
    /**
     * Gets the plateau by id
     *
     * @param int $id
     * @return Response
     */
    public function get(int $id): Response
    {
        $plateauRepository = new PlateauRepository();
        $plateau = $plateauRepository->findOne($id);

        return App::response()
            ->setStatusCode(HTTPStatusCodes::HTTP_OK)
            ->setData((array)$plateau);
    }

    /**
     * Stores te plateau
     *
     * @return Response
     */
    public function store(): Response
    {
        $plateau = new Plateau();
        $plateau->setUpperBoundX(App::request()->getParam('upper_bound_x'));
        $plateau->setUpperBoundY(App::request()->getParam('upper_bound_y'));

        $plateauRepository = new PlateauRepository();
        $plateauRepository->save($plateau);

        $data = (array)$plateau;

        return App::response()
            ->setStatusCode(HTTPStatusCodes::HTTP_CREATED)
            ->setData($data);
    }
}