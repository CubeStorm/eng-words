<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Queries;
use App\Utils\Chat;
use App\Validation\OptionValidator;
use App\Validation\WordValidator;

class WordController
{
    public function __construct(
        private Queries $queries
    ) { }

    public function index(): void
    {
        while (true) {
            $randomWord = $this->queries->getRandomWord();

            if (!$randomWord) {
                Chat::send('emptyDatabase');
                return;
            }
            
            Chat::send('showWord', $randomWord['name']);
            
            $userAnswer = Chat::input(new WordValidator(), 'Answer: ');
            $translation = json_decode($randomWord['translation']);

            $translationIsArray = is_array($translation);
            
            if (in_array($userAnswer, $translationIsArray ? $translation : [$translation])) {
                Chat::send('correctAnswer');

                continue;
            }
            
            if ($translationIsArray) {
                $translation = implode(', ', $translation);
            }
            
            Chat::send('badAnswer', $translation);
        }
    }

    public function store(): void
    {
        $name = Chat::input(new WordValidator(), 'Name (English): ');
        $translation = Chat::input(new WordValidator(), 'Translation: ');
        
        if (str_contains($translation, ',')) {
            $translation = explode(',', $translation);
            $translation = array_map('trim', $translation);
        }
        
        $this->queries->storeWord($name, $translation);
    }

    public function remove(): void
    {
        $words = $this->queries->getAllWords();

        if (!$words) {
            Chat::send('emptyDatabase');
            return;
        }

        Chat::send('allWords', $words);

        $selectedWordsNumbers = Chat::input(new OptionValidator(1, count($words)), 'Select word(s) to remove: ');
        $selectedWordsNumbers = explode(',', $selectedWordsNumbers);
        $selectedWordsNumbers = array_map('trim', $selectedWordsNumbers);

        $wordsIdsToDelete = [];

        foreach ($selectedWordsNumbers as $wordNumber) {
            $wordsIdsToDelete[] = $words[(int) $wordNumber - 1]['id'];
        }

        $this->queries->removeWords($wordsIdsToDelete);

        Chat::send('wordsRemoved');
    }

    public function list(): void
    {
        $words = $this->queries->getAllWords();

        if (!$words) {
            Chat::send('emptyDatabase');
            return;
        }

        Chat::send('allWords', $words);
    }
}