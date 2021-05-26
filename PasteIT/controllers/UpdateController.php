<?php

namespace controllers;

use core\Controller;
use core\Application;
use core\Request;
use models\Paste;
use models\User;


class UpdateController extends Controller
{
    public function handleUpdate(Request $request, $record)
    {
        if ($request->getMethod() === "get") {
            $user = new User();
            $user->loadData($request->getBody());
            /// make validation
            if (!$user->addMembership($record)) {
                Application::$app->session->setFlash('error', 'The email address is invalid!');
            } else {
                Application::$app->session->setFlash('success', 'You added a new member to modify your post');
            }
            Application::$app->response->redirect('/' . $record->slug);
            exit;
        }
    }
}
