<?php


namespace core; 

abstract class Model 
{
    
    public const RULE_EMAIL = 'email'; 
    public const RULE_MIN = 'min'; 
    public const RULE_MAX = 'max'; 
    public const RULE_MATCH = 'match'; 
    // public const RULE_REQUIRED = 'required'; 
  

    public function loadData($data) 
    {
        foreach ($data as $key => $value)
        {
            if (property_exists($this, $key)) 
            {
                $this-> {$key} = $value ; 
            }
        }
    }
    abstract public function rules() : array;
    public array $errors = [];

    public function validate()
    {
         foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute} ; 
            
            foreach ($rules as $rule) {
                $ruleName = $rule; 
                if(!is_string($ruleName))
                {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL, $rule);
                }
                if ($ruleName === self::RULE_MIN &&  strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX &&  strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
               
                if ($ruleName === self::RULE_MATCH && $value !== $this->{ $rule['match'] } ) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }
        // echo '<pre>';
        // var_dump($this->errors);
        // echo '</pre>';
        
        return empty($this->errors);
    }
 
    
    public function addError(string $attibute, string $rule, $params = []) {
        $message = $this->errorMessages()[$rule] ?? '' ; 
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message) ; 
        }
        $this->errors[$attibute] [] = $message; 

    }


    public function errorMessages() {
        return [
            self::RULE_EMAIL => 'This must be a valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => ' Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}'
        ];
    }

    public function hasErrors($attribute)
    {

        return $this->errors[$attribute] ?? false ;


    }
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }


}








































