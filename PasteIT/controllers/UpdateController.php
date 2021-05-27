<?php

namespace controllers;

use core\Controller;
use core\Application;
use core\Request;
use models\Membership;
use models\Paste;
use models\User;


class UpdateController extends Controller
{
    public function handleUpdate(Request $request, $record)
    {
        if ($request->getMethod() === "get") {
            $membership = new Membership();
            $membership->loadData($request->getBody());
            var_dump($request->getBody());
            var_dump($membership);
            exit;
            /// make validation
            if (!$membership->save()) {
                Application::$app->session->setFlash('error', 'The email address is invalid!');
            } else {
                Application::$app->session->setFlash('success', 'You added a new member to modify your post');
            }
            Application::$app->response->redirect('/' . $record->slug);
            exit;
        }
    }
}
