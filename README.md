# Valid8

class UserValidator extends Validator
{
    protected function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}

$validator = new UserValidator($data);
$validator->validate(); // returns true or false
$validator->errors(); // returns array with errors
