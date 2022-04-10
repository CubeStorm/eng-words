<?php

declare(strict_types=1);

namespace App\Utils;

class Chat
{
    public static function input(string $message = ''): string {
        return readline("\033[36m$message\033[0m");
    }

    public static function send(string $type, mixed $arg = ''): void
    {
        $chat = new self();

        match($type) {
            'welcome' => $chat->welcome(),
            'emptyDatabase' => $chat->emptyDatabase(),
            'showWord' => $chat->showWord($arg),
            'correctAnswer' => $chat->correctAnswer(),
            'badAnswer' => $chat->badAnswer($arg),
            'allWords' => $chat->allWords($arg),
            'wordsRemoved' => $chat->wordsRemoved(),
        };
    }

    private function welcome(): void
    {
        Message::color('');
        Message::color('Welcome in EngWords!');
        Message::color('');
        Message::color('Navigation:');
        Message::color('  [1] Draw random word', 'success');
        Message::color('  [2] Add word to game', 'success');
        Message::color('  [3] Remove word from game', 'success');
        Message::color('  [4] Show all words', 'success');
        Message::color('  [5] Exit program (Ctrl + C in game)', 'success');
        Message::color('');
    }

    private function emptyDatabase(): void
    {
        Message::color('Database is empty, please add some words!', 'error');
    }

    private function showWord(string $word): void
    {
        Message::color('');
        Message::color("Drew word: $word", 'warning');
    }

    private function correctAnswer(): void
    {
        Message::color('');
        Message::color('Correct! Time to rematch', 'success');
        Message::color('');
    }

    private function badAnswer(string $correctAnswer): void
    {
        Message::color('');
        Message::color("Bad! Correct answer: $correctAnswer", 'error');
    }

    private function allWords(array $words): void
    {
        $i = 1;

        Message::color('');

        foreach ($words as $word) {
            $translation = json_decode($word['translation']);

            if (is_array($translation)) {
                $translation = implode(', ', $translation);
            }

            Message::color("[$i] $word[name] ($translation)");
            $i++;
        }
        
        Message::color('');
    }

    private function wordsRemoved(): void
    {
        Message::color('');
        Message::color("Words removed successfully", 'success');
        Message::color('');
    }
}