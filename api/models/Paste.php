<?php

namespace models;

use core\Application;
use core\DbModel;


class Paste extends DbModel {
    private $id;
    private $id_user;
    private $slug;
    private $expiration;
    private $content;
    private $password;
    private $title;
    private $burn_after_read;
    private $highlight;
    private $access_modifier;
    private $CREATED_AT;
    private $UPDATED_AT;

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