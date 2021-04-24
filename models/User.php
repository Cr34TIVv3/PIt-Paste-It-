<?php

namespace models;

use core\DbModel;

class User extends DbModel
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


    public function tableName(): string
    {
        return 'users';
    }

    public function rules() : array
    {
            return [

                'username' => [ [self::RULE_MIN, 'min' => 8] , [self::RULE_MAX, 'max' => 20] ],
                'email' => [ [self::RULE_EMAIL], [self::RULE_UNIQUE,'class' => $this ] ],
                'password' => [ [self::RULE_MIN, 'min' => 8] , [self::RULE_MAX, 'max' => 20] ] , 
                'repeat' => [ [self::RULE_MATCH, 'match' => 'password'] ] 
            ];
//self::class
    }

    public function attributes() :array 
    {
         return ['username', 'email', 'password'] ; 
    }

    

     


































}