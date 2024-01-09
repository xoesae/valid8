<?php

namespace Valid8\Rules;

interface Rule
{

    public function validate(string $field, mixed $data): bool;
    public function error(): string;
}