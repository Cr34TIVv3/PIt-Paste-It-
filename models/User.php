<?php

namespace models;

use core\UserModel;
use core\Application;

class User extends UserModel
{
    public String $username = ' ';
    public String $email = ' ';
    public String $password= ' ';
    public String $repeat= ' ';
    public function save()
    {
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        return parent::save(); 
    }


    public function addMembership($record)
    {
        ///find the id  
        $sql = sprintf("SELECT id FROM users WHERE email = '%s'", $this->email);
        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        $object = $statement->fetchObject();

        if ($object == false) {
            return false;
        }
        ///insert the membership 

        $sql = sprintf('INSERT INTO members (id_paste, id_user) 
        VALUES (\'%s\',\'%s\')', $record->id,  $object->id);

        

        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        return true;

        
    }


    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules() : array
    {
            return [

                'username' => [ [self::RULE_MIN, 'min' => 8] , [self::RULE_MAX, 'max' => 20] ],
                'email' => [ [self::RULE_EMAIL], [self::RULE_UNIQUE,'class' => $this ] ],
                'password' => [ [self::RULE_MIN, 'min' => 8] , [self::RULE_MAX, 'max' => 20] ] , 
                'repeat' => [ [self::RULE_MATCH, 'match' => 'password'] ] 
            ];
    }

    public function attributes() :array 
    {
         return ['username', 'email', 'password'] ; 
    }

    
    public function getDisplayName(): string
    {
        return $this->username; 
    }
     


































}