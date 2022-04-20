<?php

namespace app\models;

class User extends UserModel
{


    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getAllNews(): array
    {
        return News::findAll(['user_id' => $this->{$this->primaryKey()}]);
    }

    /**
     * @static
     */
    public function getNewsById(int $id): News
    {
        return News::findOne(['id' => $id]);
    }

}