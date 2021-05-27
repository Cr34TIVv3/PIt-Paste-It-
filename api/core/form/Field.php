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
    public bool $flag;
  
    public function __construct(Model $model, string $attribute, bool $flag=false)
    {
        $this->type='text';

        $this->model = $model;
        
        $this->attribute = $attribute; 

        $this->flag = $flag;
        
    }

    public function __toString()
    {
      
        if($this->flag == true)
        {
            return  sprintf('
            <div class="field">
                    <input type="%s" value="%s" required  name="%s">
                    <label>%s</label>
                </div>
                <div class = "invalid-feedback"> 
                    %s
                </div> 
            ',$this->type, $this->model->{$this->attribute}, $this->attribute , $this->attribute, $this->model->getFirstError($this->attribute) ) ;
        }
        else 
        {
            
             return  sprintf('
        <div class="field">
                <input type="%s" required  name="%s">
                <label>%s</label>
            </div>
            <div class = "invalid-feedback"> 
                %s
            </div> 
        ',$this->type, $this->attribute , $this->attribute, $this->model->getFirstError($this->attribute) ) ;
        }

       
    }
    

    public function passwordField()
    {
        $this->type=self::TYPE_PASSWORD;
        return $this;
        
    }



}