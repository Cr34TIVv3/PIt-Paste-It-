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
        $tableName  = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn ($attr) => ":$attr", $attributes);
        $query = "INSERT INTO $tableName ( " . implode(',', $attributes) . ")  VALUES(" . implode(',', $params) . ")";
        $statement = self::prepare($query);
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }
    public static function getUrlService(): string
    {
        return " ";
    }


    public function deleteById($id) {
        $sql = sprintf("DELETE FROM users WHERE id = '%s'", $id);
        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        return true;
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
