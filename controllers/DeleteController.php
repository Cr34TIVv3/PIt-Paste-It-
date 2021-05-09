<?php
namespace controllers;
use core\Controller;
use models\Paste;
use core\Application;


class DeleteController extends Controller
{
    public function handleDelete($record)
    {   
        $updatedPaste = new Paste();
        $updatedPaste->delete($record);
        
        if (Application::$app->isVersion) {
            Application::$app->response->redirect('/' . Paste::findOne(["id" => $record->id])->slug);
        } else {
            Application::$app->response->redirect('/account');
        }

        
    }
}
