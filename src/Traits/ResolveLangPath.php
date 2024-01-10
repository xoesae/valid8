<?php

namespace Valid8\Traits;

trait ResolveLangPath
{
    private function getLang(string $lang, string $langDirectory): array
    {
        $langFilePath = "{$langDirectory}/{$lang}.php";

        // TODO: validate if path is valid
        $messages = include $langFilePath;

        if (! is_array($messages)) {
            // TODO: throws exception;
        }

        return $messages;
    }
}
