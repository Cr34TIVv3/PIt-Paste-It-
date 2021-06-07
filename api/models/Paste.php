<?php

namespace models;

use core\Application;
use core\DbModel;


class Paste extends DbModel
{
    // public $id;
    public $id_user;
    public $slug;
    public $expiration;
    public $content;
    public $password;
    public $title;
    public $burn_after_read;
    public $highlight;
    public $access_modifier;
    public $CREATED_AT;
    public $UPDATED_AT;

    public static function tableName(): string
    {
        return 'pastes';
    }

    public function attributes(): array
    {
        $output = [];
        $array = ['id_user', 'slug', 'expiration', 'content', 'password', 'title', 'burn_after_read', 'highlight', 'access_modifier'];
        foreach ($array as $element) {
            if (property_exists($this, $element) && isset($this->{$element})) {
                array_push($output, $element);
            }
        }
        return $output;
    }

    public static function primaryKey(): string
    {
        return "id";
    }

    public function rules(): array
    {
        return [];
    }


    public function getData($attributes = [])
    {
        $tableName  = $this->tableName();
        $params = array_map(fn ($attr) => ":$attr", $attributes);


        $statement = self::prepare("INSERT INTO $tableName ( " . implode(',', $attributes) . ") 
               VALUES(" . implode(',', $params) . ")");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();

        return true;
    }
}
