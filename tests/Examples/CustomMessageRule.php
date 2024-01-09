<?php

namespace Valid8\Test\Examples;

use Valid8\Rules\Rule;

class CustomMessageRule implements Rule
{
    protected string $field;
    protected string $message;

    public function validate(string $field, mixed $data, string $message = null): bool
    {
        $this->field = $field;
        $this->message = is_null($message) ? '{field} must be equal to an integer.' : $message;

        return is_int($data);
    }

    public function error(): string
    {
        return str_replace('{field}', $this->field, $this->message);
    }
}