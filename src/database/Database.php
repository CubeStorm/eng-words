<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class Database {
    private string $host;
    private int $port;
    private string $password;
    private string $db;
    private string $charset;
    private string $user;

    private PDO $connection;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->port = 3306;
        $this->password = '';
        $this->db = 'engwords';
        $this->charset = 'UTF8';
        $this->user = 'root';
    }

    public function __destruct()
    {
        if (!$this->connection) return;
        
        unset($this->connection);
    }

    public function connect(): void
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;port=$this->port;charset=$this->charset";

        try {
            $this->connection = new PDO($dsn, $this->user, $this->password);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}