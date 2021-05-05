<?php

namespace models;

use core\Application;
use core\Model;

class Login extends Model
{

    public string $email = ' ';
    public string $password = ' ';

    public function rules(): array
    {
        return [
              'email' => [self::RULE_EMAIL]
        ];
    }

    public function login()
    {
        
        $user = User::findOne(['email' => $this->email]) ;
        if(!$user)
        {
        
            $this->addError('email', 'User does not exist with this email'); 
            return false;
        }
        if(!password_verify($this->password, $user->password))
        {
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        return Application::$app->login($user);

    }
    
}