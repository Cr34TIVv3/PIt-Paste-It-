<?php

namespace core\form;

use core\Model;

class FieldAccount
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct(Model $model, string $attribute)
    {
        $this->type = 'text';
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return  sprintf('
        <tr>
            <th><label>%s</label></th>
            <td><input type="%s" name="%s"></td>
        </tr>
        <tr>
            <th> &nbsp; </th>
            <td>
                <div class = "invalid-feedback"> 
                    %s 
                </div> 
            </td>
        </tr>
        
        ', $this->attribute, $this->type, $this->attribute, $this->model->getFirstError($this->attribute));
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}
