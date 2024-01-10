<?php declare(strict_types=1);

namespace Valid8;

use Valid8\Rules\MapRules;
use Valid8\Rules\Rule;
use Valid8\Traits\ResolveLangPath;

class Validator
{
    use ResolveLangPath;

    private bool $isValidated = false;
    private array $data;
    private array $rules;
    private array $errors = [];
    private array $messages;
    private array $fields;

    public function __construct(array $data, array $rules = [], array $messages = [], array $fields = [], string $lang = 'en', string $langDirectory = 'lang')
    {
        $this->data = $data;
        $this->fields = empty($fields) ? static::fields() : $fields;;
        $this->rules = empty($rules) ? static::rules() : $rules;
        $allMessages = $this->getLang($lang, $langDirectory);
        $initialMessages = empty($messages) ? static::messages() : $messages;

        foreach ($initialMessages as $rule => $message) {
            $allMessages[$rule] = $message;
        }

        $this->messages = $allMessages;
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

    private function getRuleName(string|Rule $rule, Rule $instance): string
    {
        if ($rule instanceof Rule) {
            return get_class($instance);
        }

        return $rule;
    }

    private function validateRule(string $field, string|Rule $rule): void
    {
        $ruleInstance = self::getRuleInstance($rule);
        $ruleName = $this->getRuleName($rule, $ruleInstance);

        $field = $this->fields[$field] ?? $field;
        $data = $this->data[$field] ?? null;
        $message = $this->messages[$ruleName] ?? null;

        if (! $ruleInstance->validate($field, $data, $message)) {
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

    protected static function messages(): array
    {
        return [];
    }

    protected static function fields(): array
    {
        return [];
    }
}
