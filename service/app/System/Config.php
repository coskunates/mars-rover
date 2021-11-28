<?php

namespace App\System;

use App\Helpers\ArrayHelper;

/**
 * Class Config
 * @package App\System
 */
class Config
{
    // Default config path
    const CONFIG_PATH = __DIR__ . '/../../configs/';

    /**
     * @var array $configs
     */
    private static array $configs = [];

    /**
     * Load configs from config directory and filename without extension is the config key
     *
     * @return void
     */
    public static function loadConfigs(): void
    {
        $files = array_diff(scandir(self::CONFIG_PATH), ['..', '.']);
        if (!empty($files)) {
            foreach ($files as $file) {
                $fileName = pathinfo($file)['filename'];
                self::$configs[$fileName] = require_once(self::CONFIG_PATH . $fileName . '.php');
            }
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        $orderedFields = explode('.', $key);

        return ArrayHelper::findValue($orderedFields, self::$configs);
    }
}