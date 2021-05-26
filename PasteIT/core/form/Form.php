<?php 

namespace core\form;
use core\Model;
use core\form\Field;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('
        <div class="center"> 
            <div class="wrapper">
                <div itemprop="headline"  class="title">
                    Register Form
                </div>
                <form action = "%s" method = "%s">', $action ,  $method); 
        return new Form() ;
    }
  
    public static function end()
    {
        echo '</form>
            </div>
        </div>';
    }
    public function field(Model $model, $attribute, $flag=false)
    {
        return new Field($model,$attribute, $flag); 
    }



}