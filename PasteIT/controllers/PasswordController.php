<?php

namespace controllers;

use core\Controller;
use core\Request;

class PasswordController extends Controller
{

    public function handlePassword(Request $request, $record)
    {
        return $this->render('password', ['record' => $record]);
    }
}
