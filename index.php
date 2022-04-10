<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\EngWords;

$app = new EngWords();

while(true) {
    $app->init();
}