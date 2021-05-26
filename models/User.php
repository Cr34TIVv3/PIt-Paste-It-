<?php

namespace models;

use core\UserModel;
use core\Application;

class User extends UserModel
{
    public String $username = '';
    public String $email = '';
    public String $password = '';
    public String $repeat = '';
    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
    public function update()
    {
        $sql = 'UPDATE users SET';

        if (strlen($this->username) > 0) {
            $sql .= ' username= \'' . $this->username . '\'';
        }
        if (strlen($this->email) > 0) {
            $sql .= ' email= = \'' . $this->email . '\'';
        }
        if (strlen($this->password) > 0) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $sql .= ' password = \'' . $this->password . '\'';
        }

        if (strcmp($sql, 'UPDATE users SET') == 0) {
            return false;
        } else {
            $sql .= ' WHERE id =' . Application::$app->user->id;
        }

        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        return true;
    }
    public function validateMembership($record)
    {
         ///find the id  
        /// check if the email is valid 
        $sql = sprintf("SELECT id FROM users WHERE email = '%s'", $this->email);
        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        $object = $statement->fetchObject();
       /// if the email is not valid 
        if ($object == false) {
            return false;
        }
       /// if the collaborator is the owner
        if($object->id == Application::$app->user->id) 
        {
            Application::$app->session->setFlash('error', 'You are the owner of this post!');
            return false;
        }

        /// if the membership is already added 
        $sql = sprintf("SELECT COUNT(*) AS counter FROM members WHERE id_paste = '%s' AND id_user = '%s'", $record->id, $object->id);
      
        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject();
        if($result->counter > 0)
        {
            Application::$app->session->setFlash('error', 'You already added this user !'  );
            return false;
            
        }
         /// al good, the membership can be added!
         
       return true;
        
    }


    public function addMembership($record)
    {
        ///find the id  
        /// check if the email is valid 
        $sql = sprintf("SELECT id FROM users WHERE email = '%s'", $this->email);
        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        $object = $statement->fetchObject();

        if ($object == false) {
            return false;
        }

        ///check if the 
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

    public function rules(): array
    {
        return [

            'username' => [[self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 20]],
            'email' => [[self::RULE_EMAIL], [self::RULE_UNIQUE, 'class' => $this]],
            'password' => [[self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 20]],
            'repeat' => [[self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function attributes(): array
    {
        return ['username', 'email', 'password'];
    }


    public function getDisplayName(): string
    {
        return $this->username;
    }
}
