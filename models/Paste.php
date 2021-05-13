<?php

namespace models;

use core\Application;
use core\DbModel;

class Paste extends DbModel
{
    public ?int   $id_user;
    public string $slug;
    public string $expiration = "14 days";
    public string $content = '';
    public ?string $password = '';
    public string $title;
    public bool   $burn_after_read = false;
    public string $highlight;
    public string $access_modifier = 'Public';
    public string $captcha_challenge = '';
    public string $captcha_answer;


    public function submit()
    {

        if (strlen($this->password) == 0) {
            $this->password = null;
        } else {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        ///fill id_user 
        if (Application::$app->isGuest()) {
            $this->id_user = null;
        } else {
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

    public static function promote($record)
    {
        ///get the content and text from principal post 
        $sql = sprintf('SELECT pastes.content, pastes.title, pastes.UPDATED_AT FROM versions JOIN pastes ON \'%s\' = pastes.id LIMIT 1;', $record->id);
        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        $object = $statement->fetchObject(static::class);

        $old_content = $object->content;
        $old_title  = $object->title;

        $new_content = $record->content;
        $new_title = $record->title;

        // echo $old_content."<br>";
        // echo $old_title."<br>";
        // echo $new_content."<br>";
        // echo $new_title."<br>";
        // exit;


        /// swap the content and title between pastes and versions 

        $sqltime = date('Y-m-d H:i:s');
        $sqltime = date('Y-m-d H:i:s', strtotime($sqltime . ' + ' . $record->expiration));
        $record->expiration = $sqltime;


        $sql = sprintf(
            'UPDATE pastes SET expiration = \'%s\', content = \'%s\' , title = \'%s\', UPDATED_AT = \'%s\' WHERE id= \'%s\' ',
            $record->expiration,
            $new_content,
            $new_title,
            date('Y-m-d H:i:s'),
            $record->id
        );

        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        $sql = sprintf(
            'UPDATE versions SET content = \'%s\' , title = \'%s\', CREATED_AT = \'%s\' WHERE slug= \'%s\' ',
            $old_content,
            $old_title,
            $object->UPDATED_AT,
            $record->slug
        );

        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        return true;
    }


    public function update($record)
    {
        /// insert in auxiliar table old paste ! 

        $sql = 'SELECT MAX(ID) FROM PASTES';
        $statement = self::prepare("SELECT MAX(ID) AS MAX FROM PASTES");
        $statement->execute();
        $max_id = $statement->fetchObject(static::class);

        // concatenate with title 
        $this->slug = $max_id->MAX . $this->title;

        /// get the slug with sha1
        $this->slug = sha1($this->slug);

        $sql = sprintf('INSERT INTO versions (id, id_user, title, slug, content) 
            VALUES (\'%s\', \'%s\', \'%s\', \'%s\', \'%s\')', $record->id,  $record->id_user, $record->title, $this->slug, $record->content);

        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        /// update 'pastes' table with the new paste !

        $sql = sprintf(
            'UPDATE pastes SET expiration = \'%s\', content = \'%s\' , title = \'%s\', UPDATED_AT = \'%s\' WHERE id= \'%s\' ',
            $record->expiration,
            $this->content,
            $this->title,
            date('Y-m-d H:i:s'),
            $record->id
        );

        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        return true;
    }

    public function delete($record)
    {
        $sql = "";

        if (Application::$app->isVersion) {
            $sql = sprintf(
                'DELETE FROM versions WHERE slug= \'%s\' ',
                $record->slug
            );
        } else {
            $sql = sprintf(
                'DELETE FROM pastes WHERE slug= \'%s\' ',
                $record->slug
            );
        }


        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();



        // if (Application::$app->isVersion) {
        //     Application::$app->response->redirect('/' . Paste::findOne(["id" => $record->id])->slug);
        // } else {
        //     Application::$app->response->redirect('/account');
        // }
    }


    public function setCaptchaAnswer(string $value)
    {
        $this->captcha_answer = $value;
    }

    public static function tableName(): string
    {
        return 'pastes';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        if (Application::$app->isGuest()) {
            return [
                'captcha_challenge' => [[self::RULE_MATCH, 'match' => 'captcha_answer']]
            ];
        } else {
            return [];
        }
    }

    public function attributes(): array
    {
        return ['id_user', 'slug', 'expiration', 'content', 'password', 'title', 'burn_after_read', 'highlight', 'access_modifier'];
    }


    public function getDisplayTitle(): string
    {
        return $this->title;
    }
}
