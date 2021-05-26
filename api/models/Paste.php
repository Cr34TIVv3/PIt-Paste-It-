<?php

namespace models;

use core\Application;
use core\DbModel;


class Paste extends DbModel { 
    public $id;
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

    public static function tableName() : string {
        return 'paste';
    }

    public function attributes(): array {
        return ['id', 'id_user', 'slug', 'expiration', 'content', 'password', 'title', 'burn_after_read', 'highlight', 'access_modifier'];
    } 

    public static function primaryKey(): string {
        return "id";
    }

    public function rules(): array
    {
        return [];
    }


    public function getData($attributes = []) {
        
        $tableName  = $this->tableName();
        // var_dump($attributes);
        $params = array_map(fn($attr) => ":$attr", $attributes); 
      

        $statement = self::prepare("INSERT INTO $tableName ( ".implode(',' , $attributes).") 
               VALUES(".implode(',' , $params) .")"); 
       
        // var_dump(get_object_vars($this));
        
         
        foreach($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();

        return true;
    }
}