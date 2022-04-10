<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Queries;
use App\Utils\Message;

class WordController
{
    public function __construct(
        private Queries $queries
    ) { }

    public function index()
    {
        while (true) {
            $randomWord = $this->queries->getRandomWord();

            if (!$randomWord) {
                return Message::color('error', 'Database is empty, please add some words!');
            }
            
            Message::color('warning', "Word: $randomWord[name]");
            Message::color('warning', 'Your translation: ');
            
            $userAnswer = readline();
            $translation = json_decode($randomWord['translation']);

            $translationIsArray = is_array($translation);
            
            if (in_array($userAnswer, $translationIsArray ? $translation : [$translation])) {
                Message::color('info', '');
                Message::color('success', 'Correct! Time to rematch:');
                Message::send('info', '');

                continue;
            }
            
            if ($translationIsArray) {
                $translation = implode(', ', $translation);
            }
            
            Message::color('info', '');
            Message::color('error', "Bad! Correct answer: $translation");
            Message::color('info', '');
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