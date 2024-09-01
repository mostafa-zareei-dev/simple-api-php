<?php

namespace App\Database;

use PDO;
use PDOStatement;

class Database
{
    private static array $instances = [];
    public static $driver = "mysql";

    private static PDO $connection;
    private PDOStatement $statement;

    public static function getInstance(array $config, string $username, string $password): Database
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$connection = new PDO(
                self::dsn($config),
                $username,
                $password,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function query(string $query, array $params = []): Database
    {
        $this->statement = self::$connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }

    public function find(): array | false
    {
        return $this->statement->fetch();
    }

    public function findAll(): array | false
    {
        return $this->statement->fetchAll();
    }

    private static function dsn(array $config): string
    {
        $config = http_build_query($config, "", ";");

        return self::$driver . ":" . $config;
    }
}
