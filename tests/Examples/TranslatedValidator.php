<?php

namespace Valid8\Test\Examples;

use Valid8\Validator;

class TranslatedValidator extends Validator
{
    protected static function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }

    protected static function messages(): array
    {
        return [
            'required' => '{field} é obrigatório.'
        ];
    }

    protected static function fields(): array
    {
        return [
            'name' => 'nome',
        ];
    }
}