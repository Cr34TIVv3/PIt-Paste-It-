<?php

namespace core;

class PathValidator{
    public static function validatePasteGetRequest($path) {
     
        $path = substr($path, 1);
        if( strlen($path) != 40) {
            return false;
        }
        return preg_match("/[a-z0-9]{40}/", $path);
    }

    public static function validateDeleteRequest($path) {
        $path = substr($path, 1);
        if( strlen($path) != 47) { // + /Delete
            return false;
        }
        return preg_match("/[a-z0-9]{40}\/delete/", $path);
    }

    public static function validateAddUserRequest($path) {
        $path = substr($path, 1);
        if( strlen($path) != 48) { // + /addUser
            return false;
        }
        return preg_match("/[a-z0-9]{40}\/addUser/", $path);
    }
}