<?php

namespace controllers;

use core\Controller;
use models\Paste;
use core\Application;
use core\exception\ForbiddenException;
use core\Request;
use core\Response;
use models\User;

class DeleteUserController extends Controller
{
    public function handleDelete(Request $request, Response $respone, $record)
    {
        $user = new User();
        $user->deleteById($record);

        echo json_encode(array("redirect" => '/'));
        exit;
    }
}
