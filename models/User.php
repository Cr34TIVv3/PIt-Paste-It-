<?php

namespace models;

use core\UserModel;

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


    public static function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
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