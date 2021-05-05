<?php

namespace models;

use core\Application;
use core\DbModel;
use core\Model;

class Paste extends DbModel 
{
    public int    $id_user;
    public string $slug;
    public string $expiration;
    public string $content ;
    public string $password='';
    public string $title;
    public bool   $burn_after_read=false;
    public string $highlight;
    public string $access_modifier='public';

    public function submit()
    {
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        ///fill id_user 
        if(Application::$app->isGuest()) 
        {
            $this->id_user=null;
        }
        else 
        {
            $this->id_user = Application::$app->session->get('user');
        }
        //fill slug 
        //get max id from pastes 


        $sql = 'SELECT MAX(ID) FROM PASTES'; 
        $statement = self::prepare("SELECT MAX(ID) AS MAX FROM PASTES");
        $statement->execute();
        $max_id = $statement->fetchObject(static::class);
       
        // concatenate with title 
        $this->slug = $max_id->MAX . $this->title;

         /// get the slug with sha1
        $this->slug = sha1($this->slug);
        
        // var_dump(get_object_vars($this));
        return parent::save(); 
    }

    public static function tableName(): string
    {
        return 'pastes';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules() : array
    {
            return [
                
            ];
    }

    public function attributes() :array 
    {
         return ['id_user', 'slug' , 'expiration', 'content', 'password', 'title', 'burn_after_read', 'highlight' , 'access_modifier'] ; 
    }

    
    public function getDisplayTitle(): string
    {
        return $this->title; 
    }
     
}