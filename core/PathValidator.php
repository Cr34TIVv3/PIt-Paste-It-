<?php

namespace core;

class PathValidator{
    public static function validate($path) {
        // $pos = strrpos($path, "/");
        // $path = substr($path, $pos+1, strlen($path));
        $path = substr($path, 1);
        if( strlen($path) != 40) {
            return false;
        }
        return preg_match("/[a-z0-9]{40}/", $path);
    }
}