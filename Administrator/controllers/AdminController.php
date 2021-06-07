<?php


namespace controllers;

use core\Controller;
use core\Request;
use core\Response;
use core\Application;

class AdminController extends Controller
{
    public function handleAdmin(Request $request, Response $respone)
    {
        return $this->render('admin');
    }
}
