<?php

declare(strict_types=1);

namespace App\Utils;

class Chat
{
    public static function send(string $type, ?string $word = ''): void
    {
        $chat = new self();

        match($type) {
            'welcome' => $chat->welcome(),
            'emptyDatabase' => $chat->emptyDatabase(),
            'showWord' => $chat->showWord($word),
            'correctAnswer' => $chat->correctAnswer(),
            'badAnswer' => $chat->badAnswer($word),
        };
    }

    private function welcome(): void
    {
        Message::color('info', '');
        Message::color('info', 'Welcome in EngWords!');
        Message::color('info', '');
        Message::color('info', 'Navigation:');
        Message::color('success', '  [1] Draw random word');
        Message::color('success', '  [2] Add word to game');
        Message::color('success', '  [3] Exit program (Ctrl + C in game)');
        Message::color('info', '');
    }

    private function emptyDatabase(): void
    {
        Message::color('error', 'Database is empty, please add some words!');
    }

    private function showWord(string $word): void
    {
        Message::color('warning', "Drew word: $word");
        Message::color('warning', 'Your translation: ');
    }

    private function correctAnswer(): void
    {
        Message::color('info', '');
        Message::color('success', 'Correct! Time to rematch:');
        Message::color('info', '');
    }

    private function badAnswer(string $correctAnswer): void
    {
        Message::color('info', '');
        Message::color('error', "Bad! Correct answer: $correctAnswer");
        Message::color('info', '');
    }
}