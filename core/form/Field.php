<?php

namespace core\form;
use core\Model;

class Field
{
    public const TYPE_TEXT='text';
    public const TYPE_PASSWORD='password';
    public const TYPE_NUMBER='number';
    public string $type;
    public Model $model;
    public string $attribute; 
  
    public function __construct(Model $model, string $attribute)
    {
        $this->type='text';

        $this->model = $model;
        
        $this->attribute = $attribute; 
        
    }

    public function __toString()
    {
        //  echo $this->model->{$this->attribute}; 
        return  sprintf('
        <div class="field">
                <input type="%s"  required  name="%s">
                <label>%s</label>
            </div>
            <div class = "invalid-feedback"> 
                %s
            </div> 
        ',$this->type, $this->attribute , $this->attribute, $this->model->getFirstError($this->attribute) ) ;
    }
    

    public function passwordField()
    {
        $this->type=self::TYPE_PASSWORD;
        return $this;
        
    }



}