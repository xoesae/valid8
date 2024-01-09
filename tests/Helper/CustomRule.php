<?php

namespace Valid8\Test\Helper;

use Valid8\Rules\Rule;

class CustomRule implements Rule
{
    protected string $field;

    public function validate(string $field, mixed $data): bool
    {
        $this->field = $field;

        return is_int($data);
    }

    public function error(): string
    {
        return "{$this->field} must be equal to an integer.";
    }
}