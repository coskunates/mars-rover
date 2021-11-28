<?php

namespace App\System;

use PDO;
use PDOException;

/**
 * Class Database
 * @package App\System
 */
class Database
{
    /**
     * Database connection
     *
     * @var PDO|null $connection
     */
    protected static ?PDO $connection = null;

    /**
     * Database constructor
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . Config::get('database.host') . ';' .
            'port=' . Config::get('database.port') . ';dbname=' . Config::get('database.database_name');

        try {
            self::$connection = new PDO($dsn, Config::get('database.user'), Config::get('database.password'));
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection->setAttribute(PDO::ATTR_PERSISTENT, false);
        } catch (PDOException $e) {
            echo 'Could not connect to database.<hr />';
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Can not be cloned
     */
    private function __clone()
    {
    }

    /**
     * Can not be unserialize
     */
    public function __wakeup()
    {
    }

    /**
     * Return current connection
     *
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (!self::$connection) {
            new Database();
        }

        return self::$connection;
    }
}