<?php

namespace App\Exceptions;

use App\System\App;
use App\System\Message;
use App\System\Response\HTTPStatusCodes;
use App\System\Response;
use Throwable;

/**
 * Class Handler
 * @package App\Exceptions
 */
class Handler
{
    /**
     * @param Throwable $e
     * @return Response
     */
    public function handleException(Throwable $e): Response
    {
        $response = App::response();
        if ($e instanceof ValidationException || $e instanceof NoRecordException) {
            $response->setStatusCode(HTTPStatusCodes::HTTP_BAD_REQUEST)
                ->setError($e->getMessage(), $e->getCode());
        } elseif ($e instanceof MarsRoverException || $e instanceof MoveException) {
            $response->setStatusCode(HTTPStatusCodes::HTTP_OK)
                ->setError($e->getMessage(), $e->getCode());
        } elseif ($e instanceof NotFoundException) {
            $response->setStatusCode(HTTPStatusCodes::NOT_FOUND)
                ->setError(Message::get('error.page_not_found'));
        } else {
            $response->setStatusCode(HTTPStatusCodes::HTTP_BAD_REQUEST)
                ->setError(Message::get('error.error_occurred'));
        }

        return $response;
    }
}