<?php declare(strict_types=1);

namespace Valid8\Rules;

class Required implements Rule
{
    protected string $field;
    protected string $message;

    public function validate(string $field, mixed $data, string $message = null): bool
    {
        $this->field = $field;
        $this->message = is_null($message) ? '{field} is required.' : $message;

        if (is_array($data)) {
            return !empty($data);
        }

        return !is_null($data) && $data != '';
    }

    public function error(): string
    {
        return str_replace('{field}', $this->field, $this->message);
    }
}