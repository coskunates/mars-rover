<?php

namespace App\System;

use App\Helpers\ArrayHelper;

/**
 * Class Message
 * @package App\System
 */
class Message
{
    // Default message path
    const MESSAGE_PATH = __DIR__ . '/../../messages/';

    /**
     * @var array $messages
     */
    private static array $messages = [];

    /**
     * Load configs from config directory and filename without extension is the config key
     *
     * @return void
     */
    public static function loadMessages(): void
    {
        $files = array_diff(scandir(self::MESSAGE_PATH), ['..', '.']);
        if (!empty($files)) {
            foreach ($files as $file) {
                $fileName = pathinfo($file)['filename'];
                self::$messages[$fileName] = require_once(self::MESSAGE_PATH . $fileName . '.php');
            }
        }
    }

    /**
     * @param string $key
     * @return string
     */
    public static function get(string $key): string
    {
        $orderedFields = explode('.', $key);

        $message = ArrayHelper::findValue($orderedFields, self::$messages);

        return !empty($message) && is_string($message) ? $message : '';
    }
}