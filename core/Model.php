<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    //Should be called with data = request->getBody()
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($rule)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && empty($value)) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }

                //$value being an empty string is redundant for length validation
                if ($ruleName === self::RULE_EMAIL && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }

                //rule[1] is the value of the rule
                //$value being an empty string is redundant for length validation
                if ($ruleName === self::RULE_MIN && !empty($value) && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULE_MATCH);
                }

                if ($ruleName === self::RULE_UNIQUE && !$this->isUnique($attribute, $value)) {
                    $this->addErrorForRule($attribute, self::RULE_UNIQUE, $rule);
                }
            }

        }

        return empty($this->errors);
    }

    //adds error to $errors array
    private function addErrorForRule($attribute, $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError($attribute, $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'Email is not valid',
            self::RULE_MIN => 'Must be {min} characters or more',
            self::RULE_MAX => 'Must be {max} characters or fewer',
            self::RULE_MATCH => 'Values do not match',
            self::RULE_UNIQUE => 'This {unique_value} is already taken',
        ];
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? '';
    }


    abstract public function rules(): array;

    public function hasError($attribute): bool
    {
        return isset($this->errors[$attribute]);
    }

    //returns labels for form fields as an array
    public function labels(): array
    {
        return [
        ];

    }

}