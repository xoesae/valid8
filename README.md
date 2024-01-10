# Valid8: a PHP package for validation

Validations in a simple and fast way. :elephant:

# Installation

In progress :construction: :construction_worker:

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
    protected static function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
    
    protected static function messages(): array
    {
        return [
            'required' => '{field} is required.'
        ];
    }

    protected static function fields(): array
    {
        return [
            'name' => 'name',
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

working with customizable error messages:
- Use '{field}' to replace the name of field
- If is a custom rule, you can customize the message template however you want

```php
$validator = new \Valid8\Validator(
    ['name' => 'xoesae'], // data
    ['name' => ['required', new CustomRule()]], // rules
    [
        'required' => '{field} is missing.',
        CustomRule::class => '{field} not is a int'
    ] // Custom error messages
);
$validator->validate()
$validator->errors();
```

# Default rules

- Required: verify if field is present and not empty.

# Contributing
Make a Pull Request for the repository, adding its functionality along with the tests. Make sure your change doesn't break previous versions. :smile: