<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class Database {
    private string $host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;
    private string $charset;

    private PDO $connection;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->port = (int) $_ENV['DB_PORT'];
        $this->database = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->charset = $_ENV['DB_CHARSET'];
    }

    public function __destruct()
    {
        if (!$this->connection) {
            return;
        }
        
        unset($this->connection);
    }

    public function connect(): void
    {
        $dsn = "mysql:host=$this->host;dbname=$this->database;port=$this->port;charset=$this->charset";

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password);
        } catch (PDOException $error) {
            throw $error;
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}