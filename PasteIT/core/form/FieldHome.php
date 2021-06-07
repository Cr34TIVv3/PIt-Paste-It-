<?php

namespace core\form;

use core\Model;

class FieldHome
{

    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_CHECKBOX = 'checkbox';
    public string $type;
    public Model $model;
    public string $attribute;
    public string $name;

    public function __construct(Model $model, string $attribute, string $name)
    {
        $this->type = 'text';

        $this->model = $model;

        $this->attribute = $attribute;

        $this->name = $name;
    }

    public function getCheckBox()
    {
        $output = sprintf('     
        <label for="">Burn after read</label>
        <input type="checkbox" name=" %s" id="burn">
        ', $this->attribute);

        return $output;
    }

    public function getTextArea()
    {

        return sprintf('<h1 itemprop="name">New paste</h1>
        <div class="form">
            <textarea name="content" id="text-area" cols="30" rows="10"> %s </textarea>
        </div>
        <h1 itemprop="name">Optional settings</h1>
        <div class="line"></div>
        <div class="settings">', $this->model->content);
    }

    public function getSelector($params = [])  /// for every selector
    {

        $output = sprintf('
        <label itemprop="name">%s</label>
        <select itemscope itemtype="https://schema.org/Date" name="%s">', $this->name, $this->attribute);

        foreach ($params as $option) {
            $output .= sprintf('<option value="%s">%s</option>', $option, $option);
        }

        $output .= '</select>';

        return $output;
    }

    public function getInput($required = false, $break = false)  ///for password and title 
    {

        $output = sprintf('
        <label itemprop="name" > %s </label>
        ', $this->name);
        if ($break == true) {
            $output .= "<br>";
        }
        if ($required == true) {
            $output .=  sprintf('<input type="%s" name="%s" required>', $this->type, $this->attribute);
        } else {
            $output .= sprintf('<input type="%s" name="%s">', $this->type, $this->attribute);
        }

        return $output;
    }

    public function getCaptcha()
    {
        $error_message = '';
        if ($this->model->getFirstError($this->attribute) != false) {
            $error_message = 'Captcha invalid!';
        }
        return sprintf('<label for="captcha">Please Enter the Captcha Text</label>
        <img src="captcha.php" alt="CAPTCHA" class="captcha-image">
        <input type="button" id="refresh" name="captcha_challenge" value="refresh">
        <input type="text" id="captcha" name="captcha_challenge" pattern="[A-Z]{6}">
        <script src="./scripts/captcha.js" ></script>
        <div class="invalid-feedback">%s</div>', $error_message);
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}
