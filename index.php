<?php

declare(strict_types=1);

use App\EngWords;
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new EngWords();

while(true) {
    $app->init();
}