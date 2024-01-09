<?php declare(strict_types=1);

namespace Valid8;

use Valid8\Rules\MapRules;
use Valid8\Rules\Rule;

class Validator
{
    private bool $isValidated = false;
    private array $data;
    private array $rules;
    private array $errors = [];

    public function __construct(array $data, array $rules = [])
    {
        $this->data = $data;
        $this->rules = empty($rules) ? static::rules() : $rules;
    }

    private function appendError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }

    private static function getRuleInstance(string|Rule $rule): Rule
    {
        if ($rule instanceof Rule) {
            return $rule;
        }

        return new (MapRules::getRule($rule))();
    }

    private function validateRule(string $field, string|Rule $rule): void
    {
        $ruleInstance = self::getRuleInstance($rule);

        if (! $ruleInstance->validate($field, $this->data[$field] ?? null)) {
            $this->appendError($field, $ruleInstance->error());
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $rules) {
            if (is_string($rules) || $rules instanceof Rule) {
                $this->validateRule($field, $rules);
                continue;
            }

            foreach ($rules as $rule) {
                $this->validateRule($field, $rule);
            }
        }

        $this->isValidated = true;
        return empty($this->errors);
    }

    public function errors(): array
    {
        if (! $this->isValidated) {
            $this->validate();
        }

        return $this->errors;
    }

    protected static function rules(): array
    {
        return [];
    }
}
