<?php

namespace app\models;

use app\core\Model;

class ContactForm extends Model
{
    public string $subject = '';
    public string $email = '';
    public string $body = '';
    public string $date = '';
    public string $time = '';


    public function rules(): array
    {
        return [
            'subject' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'body' => [self::RULE_REQUIRED],
            'date' => [self::RULE_REQUIRED],
            'time' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'subject' => 'Subject',
            'email' => 'Email',
            'body' => 'Body',
            'button' => 'Send',
            'date' => 'Date',
            'time' => 'What time is it right now?',
        ];
    }

    public function send()
    {
        //TODO: send email
        return true;
    }
}