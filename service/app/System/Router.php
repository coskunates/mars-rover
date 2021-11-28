<?php

namespace App\System;

/**
 * Class Router
 * @package App\System
 */
class Router
{
    /**
     * @var array $routes
     */
    public static array $routes = [];

    /**
     * @param string $method
     * @param string $uri
     * @param string $namespace
     */
    public static function add(string $method, string $uri, string $namespace): void
    {
        $explodeNamespace = explode('::', $namespace);

        $method = strtolower($method);

        self::$routes[$method][$uri] = [
            'class' => $explodeNamespace[0],
            'method' => $explodeNamespace[1]
        ];
    }

    /**
     * @param string $method
     * @param string $uri
     * @return array
     */
    public static function get(string $method, string $uri): array
    {
        $method = strtolower($method);

        $result = [];
        if (!empty(self::$routes[$method][$uri])) {
            $result = self::$routes[$method][$uri];
        } else {
            foreach (self::$routes[$method] as $route => $value) {
                $params = (stripos($uri, "/") !== 0) ? "/" . $uri : $uri;
                $regex = str_replace('/', '\/', $route);
                $isMatch = preg_match('/^' . ($regex) . '$/', $params, $matches, PREG_OFFSET_CAPTURE);
                if (!empty($isMatch)) {
                    unset($matches[0]);
                    $value['args'] = array_column($matches, 0);
                    $result = $value;
                    break;
                }
            }
        }

        return $result;
    }
}