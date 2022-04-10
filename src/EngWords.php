<?php

declare(strict_types=1);

namespace App;

use App\Controllers\WordController;
use App\Database\Queries;
use App\Utils\Message;

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
        Message::send('info', '');
        Message::send('info', 'Welcome in EngWords!');
        Message::send('info', '');
        Message::send('info', 'Navigation:');
        Message::send('success', '  [1] Draw random word');
        Message::send('success', '  [2] Add word to game');
        Message::send('success', '  [3] Exit program (Ctrl + C in game)');
        Message::send('info', '');
        
        $input = readline();

        match($input) {
            default => $this->wordController->index(),
            // "1" => $this->wordController->index(),
            "2" => $this->wordController->store(),
            "3" => exit(),
        };
    }
}