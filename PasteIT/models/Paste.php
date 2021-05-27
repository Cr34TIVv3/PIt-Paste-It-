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


        $sql = sprintf(
            'UPDATE pastes SET expiration = \'%s\', content = \'%s\' , title = \'%s\', UPDATED_AT = \'%s\' WHERE id= \'%s\' ',
            $record->expiration,
            $new_content,
            $new_title,
            date('Y-m-d H:i:s'),
            $record->id
        );

        // echo $sql;
        // exit;


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

        $payload = [];
        $payload['slug'] = $record->slug;
        $payload = json_encode($payload);


        // print_r($payload);
        // exit;

        $url = 'localhost:8081/deletePaste';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");


        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $res = curl_exec($ch);

        $codHTTP = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $tip = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        if ($codHTTP == 200 && $tip == 'application/json; charset=UTF-8') {
            // header ('Content-Type: ' . $tip); // trimitem tipul MIME corespunzator (adica image/jpeg in acest caz)
            // echo $res; // afisam reprezentarea resursei obtinute (aici, imaginea in format JPEG)
            return true;
        } else {
            return false;
            // http_response_code ($codHTTP); // s-a obtinut altceva, trimitem codul de stare intors de serviciu
            // header ('Content-Type: text/plain');
            // echo 'Status code: ' . $codHTTP;

        }
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
        $output = [];
        $array = ['id_user', 'slug', 'expiration', 'content', 'password', 'title', 'burn_after_read', 'highlight', 'access_modifier'];
        foreach ($array as $element) {
            if (property_exists($this, $element) && isset($this->{$element})) {
                array_push($output, $element);
            }
        }
        return $output;
    }

    public static function getUrlService(): string
    {
        return "localhost:8081/insertPaste";
    }


    public function getDisplayTitle(): string
    {
        return $this->title;
    }
}
