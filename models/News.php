<?php

namespace app\models;

use app\core\db\DbModel;

class News extends DbModel
{

    public string $title;
    public string $body;
    public string $user_id;
    public string $news_id;

    public static function tableName()
    {
        return 'news';
    }


    public function rules(): array
    {
        return [];
    }

    public function getUser(): User
    {
        return User::findById($this->user_id);
    }

}