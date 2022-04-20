<?php

namespace app\models;

abstract class UserModel extends \app\core\db\DbModel
{
    abstract public function getDisplayName(): string;

    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $passwordConfirm = '';

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            //doesn't make sense in the real world to limit the length of the firstname
            //but it's a good example of how to use the validation rules
            'firstname' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 10]],

            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED,
                self::RULE_EMAIL, [self::RULE_UNIQUE, 'unique_value' => 'email']],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function attributes(): array
    {
        return [
            'firstname',
            'lastname',
            'email',
            'password',
        ];
    }

    public function labels(): array
    {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'passwordConfirm' => 'Confirm Password',
        ];
    }

    public static function tableName(): string
    {
        return 'users';
    }
}