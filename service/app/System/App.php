<?php

namespace App\System;

use App\Exceptions\Handler;
use PDO;

/**
 * Class App
 * @package App\System
 */
class App
{
    /**
     * @var Request|null $request
     */
    protected static ?Request $request = null;

    /**
     * @var Response|null $response
     */
    protected static ?Response $response = null;

    /**
     * Run the application
     */
    public function run(): void
    {
        // Loading configurations
        Config::loadConfigs();
        Message::loadMessages();

        self::$request = new Request();
        self::$response = new Response();

        // Setting exception handler
        $exceptionHandler = new Handler();
        set_exception_handler([$exceptionHandler, 'handleException']);
        register_shutdown_function([self::$response, 'generateResponse']);

        self::$request->start();
    }

    /**
     * Return the database connection
     *
     * @return PDO
     */
    public static function db(): PDO
    {
        return Database::getConnection();
    }

    /**
     * @return Request
     */
    public static function request(): Request
    {
        return self::$request;
    }

    /**
     * @return Response
     */
    public static function response(): Response
    {
        return self::$response;
    }
}