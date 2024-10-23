<?php

namespace App\Middlewares;

class Route
{
    private static $routes = [
        'GET' => [],
        'POST' => [],
        'PATCH' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    /**
     *  Добавляет роут с указанным функционалом
     *
     *  @param $method - метод, для которого нужно добавить роут
     *  @param $route - путь роута
     *  @param $action - действие для роута
     *  @return void
     */
    private static function addRoute($method, $route, $action): void
    {
        $route = self::formatRoute($route);
        self::$routes[$method][$route] = $action;
    }

    /**
     *  @param $action - дейсвие для роута
     *  @param $params - параметры (необязательно)
     *  @return void
     */
    private static function callAction($action, $params): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        $requestData = file_get_contents('php://input');
        $jsonData = json_decode($requestData, true);

        if (is_callable($action))
            call_user_func_array($action, array_merge($params, [$jsonData]));
        else if (is_string($action) && str_contains($action, '@'))
        {
            // Делит класс и метод
            list($class, $method) = explode('@', $action);

            // Проверяет, не пустое лих их значение, и если нет - выполняет метод этого класса, передавая агрументы $params
            if (class_exists($class) && method_exists($class, $method))
                call_user_func_array([new $class, $method], array_merge($params, [$jsonData]));
        }
    }

    private static function formatRoute($route): string
    {
        return rtrim($route, '/');
    }

    public static function get($route, $action): void
    {
        self::addRoute('GET', $route, $action);
    }

    public static function post($route, $action): void
    {
        self::addRoute('POST', $route, $action);
    }

    public static function patch($route, $action): void
    {
        self::addRoute('PATCH', $route, $action);
    }

    public static function put($route, $action): void
    {
        self::addRoute('PUT', $route, $action);
    }

    public static function delete($route, $action): void
    {
        self::addRoute('DELETE', $route, $action);
    }


    /**
     *  Обрабатывает роуты
     *
     *  @return void
     */
    public static function match() : void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = self::formatRoute(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        foreach (self::$routes[$method] as $route => $action)
        {
            $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $route);
            if (preg_match("#^$routePattern$#", $uri, $matches))
            {
                array_shift($matches);
                self::callAction($action, $matches);
                return;
            }
        }

        // Перенаправление на 404.php
        include __DIR__ . "/../../404.php";
        exit();
    }


}