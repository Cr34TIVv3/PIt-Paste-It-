<?php

namespace controllers;

use core\Controller;
use core\Application;
use core\Request;
use models\Paste;

class PreviewController extends Controller
{
    public function handlePreview(Request $request, $record)
    {
        if ($request->getMethod() === 'post') {

            if (!Application::$app->isVersion) {
                $updatedPaste = new Paste();
                $updatedPaste->loadData($request->getBody());
            
                ///make some validations 
                
                if ($updatedPaste->update($record)) {
                    Application::$app->response->redirect('/'.$record->slug);
                    exit;
                }
                return $this->render('preview', ['record' => $record]);
            }
        else {
            if (Paste::promote($record)) {
                Application::$app->response->redirect('/'.Paste::findOne(["id" => $record->id])->slug);
                exit;
            }
            return $this->render('preview', ['record' => $record]);
        }
        } else {
            return $this->render('preview', ['record' => $record]);
        }
    }
}
