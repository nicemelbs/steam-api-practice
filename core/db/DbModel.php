<?php

namespace app\core\db;

use app\core\Application;
use app\core\Model;
use PDOStatement;

abstract class DbModel extends Model
{
    public static function findAll(array $attributes = []): array
    {
        $statement = self::prepareStatement($attributes);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public static function findById(string $id): ?self
    {
        return self::findOne(['id' => $id]);
    }


    //save data to database

    public function save()
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();

        $params = array_map(function ($attribute) {
            return ':' . $attribute;
        }, $attributes);

        $query = "INSERT IGNORE INTO $tableName (";
        $query .= implode(',', $attributes);
        $query .= ') VALUES (';
        $query .= implode(',', $params);
        $query .= ')';

        $statement = self::prepare($query);

        foreach ($attributes as $attribute) {
            $statement->bindValue(':' . $attribute, $this->{$attribute});
        }

        return $statement->execute();
    }

    abstract public static function tableName();

    //find one record with attribute values

    private static function prepare(string $query)
    {
        return Application::$app->db->pdo->prepare($query);
    }

    //find all records with attribute values

    public function isUnique($attribute, $value): bool
    {
        static::findOne([$attribute => $value]);
        return empty($result);
    }

    public static function findOne(array $attributes): ?self
    {
        $statement = self::prepareStatement($attributes);
        $statement->execute();
        $object = $statement->fetchObject(static::class);

        if ($object === false) return null;
        return $object;
    }

    protected static function prepareStatement(array $attributes): PDOStatement
    {

        $tableName = static::tableName();

        if (empty($attributes)) {
            $query = "SELECT * from $tableName";
        } else {
            $query = "SELECT * FROM $tableName WHERE ";
            $query .= implode(' AND ', array_map(function ($attribute) {
                return "$attribute = :$attribute";
            }, array_keys($attributes)));
        }
        $statement = self::prepare($query);
        foreach ($attributes as $param => $value) {
            $statement->bindValue(':' . $param, $value);
        }
        return $statement;
    }

    public function primaryValue()
    {
        return $this->{$this->primaryKey()};
    }

    public function primaryKey(): string
    {
        return 'id';
    }

}