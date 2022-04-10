<?php

declare(strict_types=1);

namespace App;

use App\Controllers\WordController;
use App\Database\Queries;
use App\Utils\Chat;

require_once __DIR__ . '/../vendor/autoload.php';

class EngWords
{
    private Queries $queries;
    private WordController $wordController;

    public function __construct()
    {
        $this->queries = new Queries();
        $this->queries->createTables();

        $this->wordController = new WordController($this->queries);
    }

    public function init(): void
    {
        Chat::send('welcome');
        
        $input = readline();

        match($input) {
            default => $this->wordController->index(),
            // "1" => $this->wordController->index(),
            "2" => $this->wordController->store(),
            "3" => $this->wordController->remove(),
            "4" => exit(),
        };
    }
}