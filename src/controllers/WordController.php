<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Queries;
use App\Utils\Message;

class WordController
{
    private Queries $queries;

    public function __construct(Queries $queries) {
        $this->queries = $queries;
    }

    public function index()
    {
        while (true) {
            $randomWord = $this->queries->getRandomWord();

            if (!$randomWord) {
                return Message::send('error', 'Database is empty, please add some words!');
            }
            
            Message::send('warning', "Word: $randomWord[name]");
            Message::send('warning', 'Your translation: ');
            
            $userAnswer = readline();
            $translation = json_decode($randomWord['translation']);

            $translationIsArray = is_array($translation);
            
            if (in_array($userAnswer, $translationIsArray ? $translation : [$translation])) {
                Message::send('info', '');
                Message::send('success', 'Correct! Time to rematch:');
                Message::send('info', '');

                continue;
            }
            
            if ($translationIsArray) {
                $translation = implode(', ', $translation);
            }
            
            Message::send('info', '');
            Message::send('error', "Bad! Correct answer: $translation");
            Message::send('info', '');
        }
    }

    public function store()
    {
        $name = readline('Name (English): ');
        $translation = readline('Translation: ');

        if (str_contains($translation, ',')) {
            $translation = explode(',', $translation);
            $translation = array_map('trim', $translation);
        }

        $this->queries->storeWord($name, $translation);
    }
}