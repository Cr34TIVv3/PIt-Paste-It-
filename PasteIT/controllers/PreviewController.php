<?php

namespace controllers;

use core\Controller;
use core\Application;
use core\Request;
use core\Response;
use models\Paste;

class PreviewController extends Controller
{
    public function handlePreview(Request $request, Response $response, $record)
    {
        if ($request->getMethod() === 'post') {

            if (!Application::$app->isVersion) {
                $updatedPaste = new Paste();
                $updatedPaste->loadData($request->getBody());

                ///make some validations 

                if ($updatedPaste->update($record)) {
                    Application::$app->session->setFlash('success', "Paste updated!");
                    Application::$app->response->redirect('/' . $record->slug);
                    exit;
                }
                return $this->render('preview', ['record' => $record]);
            } else {
                if (Paste::promote($record)) {
                    Application::$app->response->redirect('/' . Paste::findOne(["id" => $record->id])->slug);
                    exit;
                }
                return $this->render('preview', ['record' => $record]);
            }
        } else {

            if (Application::$app->isOwner($record->id_user)) {
                return $this->render('preview', ['record' => $record]);
            } else {

                if (strcmp($record->burn_after_read, '1') == 0) {
                    if ($record->password == null) {
                        return $this->render('preview', ['record' => $record]);
                    }

                    if (!isset($_GET['enter_password'])) {
                        Application::$app->response->redirect('/' . $record->slug . '/password');
                    } else {
                        if (password_verify($_GET['enter_password'], $record->password)) {
                            Application::$app->session->setFlash('success', 'Permission accepted!');
                            $updatedPaste = new Paste();
                            $updatedPaste->delete($record);
                            return $this->render('preview', ['record' => $record]);
                        } else {
                            Application::$app->session->setFlash('error', 'Permission denied!');
                            Application::$app->response->redirect('/' . $record->slug . '/password');
                        }
                    }
                    return $this->render('preview', ['record' => $record]);
                }
            }

            if ($record->password == null) {
                return $this->render('preview', ['record' => $record]);
            }

            if (!isset($_GET['enter_password'])) {
                Application::$app->response->redirect('/' . $record->slug . '/password');
            } else {
                if (password_verify($_GET['enter_password'], $record->password)) {
                    Application::$app->session->setFlash('success', 'Permission accepted!');
                    return $this->render('preview', ['record' => $record]);
                } else {
                    Application::$app->session->setFlash('error', 'Permission denied!');
                    Application::$app->response->redirect('/' . $record->slug . '/password');
                }
            }
            return $this->render('preview', ['record' => $record]);
        }
    }
}
