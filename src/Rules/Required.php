<?php declare(strict_types=1);

namespace Valid8\Rules;

class Required implements Rule
{
    protected string $field;

    public function validate(string $field, mixed $data): bool
    {
        $this->field = $field;

        if (is_array($data)) {
            return !empty($data);
        }

        return !is_null($data) && $data != '';
    }

    public function error(): string
    {
        return "{$this->field} is required.";
    }
}