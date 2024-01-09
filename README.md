# Valid8: a PHP package for validation

Validations in a simple and fast way.

# Installation

In progress :construction:

# Usage

Using Valid8 is easy, it consists of instantiating the class passing its data array and an array of rules

```php
$validator = new \Valid8\Validator(
    ['name' => 'xoesae'], // data
    ['name' => ['required']], // rules
);

$isValid = $validator->validate();

if ($isValid) {
    // ...
} else {
    // Some error happened
    $errors = $validator->errors();
    var_dump($errors);
}
```

Another valid8 approach is to extend the validator class to create a custom validator:

```php
class UserValidator extends \Valid8\Validator
{
    protected function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}

$validator = new UserValidator($data);
$validator->validate()
$validator->errors();
```

It's also easy to add new customizable rules, so need implements the `\Valid8\Rules\Rule` interface:

```php
class CustomRule implements \Valid8\Rules\Rule
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

$validator = new \Valid8\Validator(
    ['name' => 'xoesae'], // data
    ['name' => [new CustomRule()]], // rules
);
$validator->validate()
$validator->errors();
```

# Default rules

- Required: verify if field is present and not empty.

# Contributing
Check the CONTRIBUTING.md