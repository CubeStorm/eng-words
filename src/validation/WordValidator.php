<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as Validation;

require_once __DIR__ . '/../../vendor/autoload.php';

class WordValidator implements Validator
{
    public function validate($value): bool
    {
        return Validation::stringType()
            ->notEmpty()
            ->alpha('-', ' ', '\'')
            ->length(2, null)
            ->validate($value);
    }

    public function getMessage(): string
    {
        return "Invalid answer";
    }
}