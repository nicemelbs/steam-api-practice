<?php

namespace app\models;

use app\core\Application;
use app\core\db\DbModel;

class NewsForm extends DbModel
{
    public string $title = '';
    public string $body = '';
    public string $user_id;

    public function rules(): array
    {
        return [
            'title' => [self:: RULE_REQUIRED],
            'body' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'title' => 'News Title',
            'body' => 'Body'
        ];

    }

    public function attributes(): array
    {
        return ['title', 'body', 'user_id'];
    }

    public function save()
    {
        $user = Application::$app->user;
        $this->user_id = $user->primaryValue();
        return parent::save();
    }

    public static function tableName()
    {
        return 'news';
    }

}