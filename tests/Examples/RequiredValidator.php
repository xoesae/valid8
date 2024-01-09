<?php

namespace Valid8\Test\Examples;

use Valid8\Validator;

class RequiredValidator extends Validator
{
    protected static function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}