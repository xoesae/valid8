<?php

namespace Valid8\Rules;

interface Rule
{

    public function validate(string $field, mixed $data, string $message = null): bool;
    public function error(): string;
}