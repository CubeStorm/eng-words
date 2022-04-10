<?php

declare(strict_types=1);

namespace App\Database;

use App\Database\Database;
use PDO;

class Queries
{
    private Database $database;
    private PDO $connection;

    public function __construct() {
        $this->database = new Database();
        $this->database->connect();

        $this->connection = $this->database->getConnection();
    }

    public function createTables(): void
    {
        $statement = $this->connection->query('
            CREATE TABLE IF NOT EXISTS words (
                id INT NOT NULL AUTO_INCREMENT,
                name VARCHAR(45) NOT NULL UNIQUE,
                translation TEXT NOT NULL,
                PRIMARY KEY (id)
            )
        ');

        $statement->execute();
    }

    public function getRandomWord(): mixed
    {
        $statement = $this->connection->query('SELECT * FROM words ORDER BY RAND() LIMIT 1');

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getWords(): mixed
    {
        $statement = $this->connection->query('SELECT * FROM words');

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function storeWord(string $name, string | array $translation): void
    {
        $translation = json_encode($translation);

        $statement = $this->connection->prepare("
            INSERT INTO words 
            (name, translation) VALUES (:name, :translation)
        ");
        
        $statement->bindParam(':name', $name);
        $statement->bindParam(':translation', $translation);
        $statement->execute();
    }
    
    public function removeWords(array $ids): void
    {
        $params = implode(', :', $ids);

        $statement = $this->connection->prepare("
            DELETE FROM words
            WHERE id IN(:$params) 
        ");

        foreach ($ids as $key => &$val) {
            $statement->bindParam("$val", $val);
        }

        $statement->execute();
    }
}