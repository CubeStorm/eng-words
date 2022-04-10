<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Queries;
use App\Utils\Chat;

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
                return Chat::send('emptyDatabase');
            }
            
            Chat::send('showWord', $randomWord['name']);
            
            $userAnswer = readline();
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