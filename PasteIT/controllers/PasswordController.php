<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\exception\NotFoundException;
use core\Request;
use core\Response;

class PasswordController extends Controller
{

    public function handlePassword(Request $request, Response $response, $record)
    {
        if (Application::$app->isVersion) {
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }
        return $this->render('password', ['record' => $record]);
    }


}
