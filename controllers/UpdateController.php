<?php

namespace controllers;

use core\Controller;
use core\Application;
use core\Request;
use models\Paste;
use models\User;
use core\exception\ForbiddenException;

class UpdateController extends Controller
{
    public function handleUpdate(Request $request, $record)
    {
        if ($request->getMethod() === "get") {

            if (!(Application::$app->isOwner($record->id_user) || Application::$app->isMember($record->id))) {
                throw new ForbiddenException();
            }

            $user = new User();
            $user->loadData($request->getBody());
            /// make validation
            if ($user->validateMembership($record) && $user->addMembership($record)) {
                Application::$app->session->setFlash('success', 'You added a new member to modify your post');
            }
            Application::$app->response->redirect('/' . $record->slug);
            exit;
        }
    }
}
