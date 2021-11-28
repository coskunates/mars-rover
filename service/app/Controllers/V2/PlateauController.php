<?php

namespace App\Controllers\V2;

use App\Controllers\Controller;
use App\Repositories\PlateauRepository;
use App\System\App;
use App\System\Response;
use App\System\Response\HTTPStatusCodes;

/**
 * Class PlateauController
 * @package App\Controllers\V2
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

        $result = (array)$plateau;
        $result['version'] = 'v2';

        return App::response()
            ->setStatusCode(HTTPStatusCodes::HTTP_OK)
            ->setData($result);
    }
}