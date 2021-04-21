<?php

namespace models;

use core\Model;

class RegisterModel extends Model
{
   
    public String $username = ' ';
    public String $email = ' ';
    public String $password= ' ';
    public String $repeat= ' ';
 
    public function register()
    {
        // echo "register ok";
    }


    public function rules() : array
    {
            return [

                'username' => [ [self::RULE_MIN, 'min' => 8] , [self::RULE_MAX, 'max' => 20] ],
                'email' => [ [self::RULE_EMAIL], [self::RULE_MIN, 'min' => 8] , [self::RULE_MAX, 'max' => 20]],
                'password' => [ [self::RULE_MIN, 'min' => 8] , [self::RULE_MAX, 'max' => 20] ] , 
                'repeat' => [ [self::RULE_MATCH, 'match' => 'password'] ] 
            ];


    }

     


































}