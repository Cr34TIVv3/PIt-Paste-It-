<?php

namespace core\exception;

use Exception;

class BadRequest extends Exception
{

    protected $message = 'You don t have the permission to add user';
    protected $code = 400;
}
