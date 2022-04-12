<?php

declare(strict_types=1);

use App\Database\Database;
use App\Database\Queries;
use PHPUnit\Framework\TestCase;

class MigrationsTest extends TestCase
{
    private Database $database;
    private Queries $queries;

    protected function setUp(): void
    {
        $this->database = new Database();
        $this->database->connect();

        $this->queries = new Queries();
    }

    protected function tearDown(): void
    {
        $this->database->getConnection()->query('DROP TABLE words');
        unset($this->database);
        unset($this->queries);
    }

    public function testThatWordsTableShouldCreate(): void
    {
        $this->queries->createTables();

        $query = $this->database->getConnection()->query('SHOW TABLES LIKE "words"');
        $results = $query->fetchAll();

        $tableExists = $results !== false && count($results) > 0;
    
        $this->assertTrue($tableExists);
    }
}