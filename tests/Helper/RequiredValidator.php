<?php

namespace Xoesae\Valid8\Test\Helper;

use Xoesae\Valid8\Validator;

class RequiredValidator extends Validator
{
    protected static function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}