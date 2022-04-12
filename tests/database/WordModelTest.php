<?php

declare(strict_types=1);

use App\Database\Database;
use App\Database\Queries;
use PHPUnit\Framework\TestCase;

class WordModelTest extends TestCase
{
    private Database $database;
    private Queries $queries;

    protected function setUp(): void
    {
        $this->database = new Database();
        $this->database->connect();

        $this->queries = new Queries();
        $this->queries->createTables();
    }

    protected function tearDown(): void
    {
        $this->database->getConnection()->query('DROP TABLE words');
        unset($this->database);
        unset($this->queries);
    }

    public function testCreateWordWithSpecificNameAndTranslationAction(): void
    {
        $this->queries->storeWord('house', 'dom');

        $query = $this->database->getConnection()->query('SELECT * FROM words WHERE name = "house" LIMIT 1');
        $results = $query->fetch();

        $this->assertNotFalse($results);
    }

    public function testCannotCreateWordWithoutTranslation(): void
    {
        $this->queries->storeWord('house', []);

        $query = $this->database->getConnection()->query('SELECT * FROM words WHERE name = "house" LIMIT 1');
        $results = $query->fetch();

        $this->assertFalse($results);
    }

    public function testCanCreateWordWithMultipleTranslations(): void
    {
        $this->queries->storeWord('house', ['dom', 'domek', 'chatka']);

        $query = $this->database->getConnection()->query('SELECT * FROM words WHERE name = "house" LIMIT 1');
        $results = $query->fetchAll();
        
        $word = $results[0];
        $translations = json_decode($word['translation']);

        $this->assertCount(3, $translations);
        $this->assertEquals('dom', $translations[0]);
        $this->assertEquals('domek', $translations[1]);
        $this->assertEquals('chatka', $translations[2]);
    }

    public function testRemoveWordAction(): void
    {
        // create word to delete
        $this->queries->storeWord('house', 'dom');

        // get created word
        $query = $this->database->getConnection()->query('SELECT * FROM words WHERE name = "house" LIMIT 1');
        $wordsToDelete = $query->fetchAll();
        
        // remove word
        $this->queries->removeWords([$wordsToDelete[0]['id']]);
        
        // check that word not exists in database
        $query = $this->database->getConnection()->query('SELECT * FROM words WHERE name = "house" LIMIT 1');
        $potentialWord = $query->fetchAll();
        
        $this->assertEmpty($potentialWord);
    }

    public function testGetRandomWordActionReturnOnlyOneWord(): void
    {
        // create words to delete
        $this->queries->storeWord('house', 'dom');
        $this->queries->storeWord('place', 'miejsce');
        $this->queries->storeWord('witch', 'czarownica');
        $this->queries->storeWord('php', 'php');
        $this->queries->storeWord('mouse', 'mysz');
        $this->queries->storeWord('cow', 'krowa');

        // get word
        $randomWord = $this->queries->getRandomWord();
    
        $this->assertCount(1, $randomWord);
    }

    public function testGetAllWordsReturnAllRecords(): void
    {
        // create words to delete
        $this->queries->storeWord('move', 'przenosic');
        $this->queries->storeWord('dog', 'pies');
        $this->queries->storeWord('computer', 'komputer');
        $this->queries->storeWord('js', 'js');
        $this->queries->storeWord('screen', 'ekran');
        $this->queries->storeWord('window', 'okno');
        $this->queries->storeWord('grass', 'trawa');

        $words = $this->queries->getAllWords();

        $this->assertCount(7, $words);
        $this->assertEquals('move', $words[0]['name']);
        $this->assertEquals('ekran', json_decode($words[4]['translation']));
        $this->assertEquals('grass', $words[6]['name']);
    }
}