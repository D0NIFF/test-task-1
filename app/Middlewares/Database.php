<?php

namespace App\Middlewares;

use App\Middlewares\Configuration;

class Database
{
    private static $connection;

    private static function initialize(): void
    {
        $driver = Configuration::get('DB_DRIVER');
        $host = Configuration::get('DB_HOST');
        $user = Configuration::get('DB_USER');
        $password = Configuration::get('DB_PASSWORD');
        $dbname = Configuration::get('DB_NAME');
        self::$connection = new \PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    }

    private static function closeConnection(): void
    {
        self::$connection = null;
    }

    public static function query(string $query)
    {
        self::initialize();
        $statement = self::$connection->prepare($query);
        $statement->execute();
        self::closeConnection();
        return $statement;
    }

    public static function insert(string $table, array $data)
    {
        self::initialize();
        $sql = "INSERT INTO $table (";
        $sqlValues = "VALUES (";
        foreach ($data as $key => $value)
        {
            $sql .= "$key, ";
            $sqlValues .= ":$key, ";
        }
        $sql = substr($sql, 0, -2) . ") " . substr($sqlValues, 0, -2) . ")";

        $statement = self::$connection->prepare($sql);
        $statement->execute($data);
        self::closeConnection();
        return $statement;
    }

    public static function update(string $table, string|int $id, array $data)
    {
        self::initialize();
        $sql = "UPDATE `$table` SET ";
        foreach ($data as $key => $value)
        {
            $sql .= "`$key`='$value', ";
        }
        $sql = substr($sql, 0, -2) . " WHERE `id` = $id;";
        $statement = self::$connection->prepare($sql);
        $statement->execute();
        self::closeConnection();
        return $statement;
    }
}