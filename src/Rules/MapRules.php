<?php

namespace Valid8\Rules;

class MapRules
{
    public static function getRule(string $name): string
    {
        return match ($name) {
            'required' => Required::class,
            'email' => Email::class,
        };
    }
}