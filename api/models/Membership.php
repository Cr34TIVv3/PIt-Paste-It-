<?php

namespace models;

use core\Application;
use core\DbModel;


class Membership extends DbModel { 
    // public $id;
    public $id_paste;
    public $id_user;
 

    public static function tableName() : string {
        return 'members';
    }

    public function attributes(): array {
        $output = [];
        $array = ['id_user', 'id_paste' ];
        foreach($array as $element)
        {
            if(property_exists($this, $element) && isset($this->{$element}) )
            {
                array_push($output, $element);
            }
        }
        return $output;
    } 
    public static function primaryKey(): string {
        return "id";
    }

    public function rules(): array
    {
        return [];
    }
}












