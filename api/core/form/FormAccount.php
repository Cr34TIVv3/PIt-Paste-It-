<?php 

namespace core\form;
use core\Model;

class FormAccount
{
    public static function begin($action, $method)
    {
        echo sprintf('
        <div class="yourProfile">
            <table class="informationAccount" itemscope itemtype="https://schema.org/Table">
                <form action = "%s" method = "%s">', $action ,  $method); 
        return new FormAccount() ;
    }
  
    public static function end()
    {
        echo '</form>
            </table>
        </div>';
    }
    public function field(Model $model, $attribute)
    {
        return new FieldAccount($model,$attribute); 
    }



}