<?php

namespace core\form;

use core\Model;

class FormHome{
    public static function begin($action, $method)
    {
        echo sprintf(' <form action="%s" method="%s" enctype="multipart/form-data">', $action ,  $method); 
        return new FormHome() ;
    }
  
    public static function end()
    {
        echo '</form> ';
    }
    public function field(Model $model, $attribute, $name)
    {
        return new FieldHome($model, $attribute, $name); 
    }

}