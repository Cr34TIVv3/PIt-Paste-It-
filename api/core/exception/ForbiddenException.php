<?php

namespace core\exception;

use Exception;

class ForbiddenException extends Exception{
   
    protected $message = 'You don t have the permission'; 
    protected $code = 403;



}