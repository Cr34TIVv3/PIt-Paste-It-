<?php

namespace models;

use core\Application;
use core\DbModel;

class Membership extends DbModel
{
    public $id_paste;
    public $id_user;

    public static function getUrlService(): string
    {
        return "localhost:8081/addMember";
    }

   
    public static function tableName(): string
    {
        return 'members';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return ['id_user', 'id_paste'];
    }


    public function getDisplayTitle(): string
    {
        return $this->title;
    }
}
