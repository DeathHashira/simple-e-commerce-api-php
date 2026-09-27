<?php

namespace Model;

use PDO;

class Database
{
    public ?PDO $conn;

    public function __construct(
        private string $dbName,
        private string $dbHost,
        private string $dbUser,
        private string $dbPass
    ) {
        $this->conn = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPass);
    }

    public static function createFromEnv(): self
    {
        return new self($_ENV["DB_NAME"], $_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}
