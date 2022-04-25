<?php

namespace app\models;

use app\core\db\DbModel;

class Cache extends DbModel
{
    public string $cacheKey;
    public string $cacheValue;

    public static function tableName()
    {
        return 'cache';
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
    }

    public function attributes()
    {
        return ['cacheKey', 'cacheValue'];
    }
}