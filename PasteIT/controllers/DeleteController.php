<?php

namespace controllers;

use core\Controller;
use models\Paste;
use core\Application;
use core\exception\ForbiddenException;
use core\Request;
use core\Response;

class DeleteController extends Controller
{
    public function handleDelete(Request $request, Response $respone, $record)
    {
        if (!(Application::$app->isOwner($record->id_user) || Application::$app->isMember($record->id))) {
            throw new ForbiddenException();
        }

        $updatedPaste = new Paste();
        $updatedPaste->slug = $record->slug;
        $updatedPaste->delete($record);

        if (Application::$app->isVersion) {
            echo json_encode(array("redirect" => '/' . Paste::findOne(["id" => $record->id])->slug));
            exit;
        } else {
            echo json_encode(array("redirect" => '/account'));
            exit;
        }
    }
}
