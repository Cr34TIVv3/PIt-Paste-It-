<?php

namespace core;

class Request {
    
    public function getPath() 
   {
        $path = $_SERVER['REQUEST_URI'] ?? '/' ; 
        $position = strpos ($path, '?') ; 
        if( $position == false )
        {
            return $path;
        }
        $path = substr($path, 0, $position); 
        return $path;
        
    }

    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']); 
    }


    public function getBody() {
        $body = [];
        if($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
            }    
        }
        if($this->getMethod() === 'post') {
            $data = json_decode(file_get_contents("php://input"));
            foreach ($data as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }    
        }
        return $body;
    }

}