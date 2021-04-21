<?php

namespace core\form;
use core\Model;

class Field
{
    public Model $model;
    public string $attribute; 
  
    public function __construct(Model $model, string $attribute)
    {
        // echo "nu intru";
        $this->model = $model ;
        $this->attribute = $attribute; 
        
    }

    public function __toString()
    {
        //  echo $this->model->{$this->attribute}; 
        return  sprintf('
        <div class="field">
                <input type="text"  required  name="%s">
                <label>%s</label>
            </div>
            <div class = "invalid-feedback"> 
                %s
            </div> 
        ', $this->attribute , $this->attribute, $this->model->getFirstError($this->attribute) ) ;
    }



}