<?php

namespace App\Models;

use App\Database\Database;

abstract class Model {
    protected Database $db;
    protected string $tableName = "";

    public function __construct()
    {
        $config = [
            'dbname' => $_ENV['DATABASE_NAME'],
            'host' => $_ENV['DATABASE_HOST'],
            'port' => $_ENV['DATABASE_PORT'],
        ];

        $username = $_ENV["DATABASE_USER"];
        $password = $_ENV["DATABASE_PASSWORD"];

        $this->db = Database::getInstance($config, $username, $password);
    }
}