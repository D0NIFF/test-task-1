<?php

namespace App\Middlewares;

class Configuration
{
    public static $configiguration;

    /**
     *  Инициализирует конфиг, беря даггые из конфигурационного файла .env в корневой папке
     *
     *  @return void
     */
    public static function initialize() : void
    {
        $configFile = fopen(__DIR__ . "/../../.env",'r');
        while (!feof($configFile))
        {
            $line = str_replace(array("\r", "\n", '"'), '', fgets($configFile));
            list($key, $value) = explode('=', $line);
            self::$configiguration[trim($key)] = $value ?? "";
        }
        fclose($configFile);
    }

    /**
     *  Возращает конфиг по ключу
     *
     *  @param string $key
     *  @return mixed
     */
    public static function get(string $key) : mixed
    {
        return self::$configiguration[$key] ?? null;
    }

    /**
     *  Заполняет значение для заданного ключа
     *
     *  @param string $key Ключ, для которого будет заданно значение
     *  @param mixed $value Значение
     *  @return void
     */
    public static function set(string $key, mixed $value) : void
    {
        self::$configiguration[$key] = $value;
    }
}