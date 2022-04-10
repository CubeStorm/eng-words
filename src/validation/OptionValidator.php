<?php

declare(strict_types=1);

namespace App\Validation;

use Respect\Validation\Validator as Validation;

require_once __DIR__ . '/../../vendor/autoload.php';

class OptionValidator implements Validator
{
    public function __construct(
        private int $min,
        private int $max
    ) {

    }

    public function validate($value): bool
    {
        return Validation::intVal()
            ->noWhitespace()
            ->between($this->min, $this->max)
            ->validate($value);
    }

    public function getMessage(): string
    {
        return "Invalid option (select $this->min-$this->max)";
    }
}