<?php

namespace controllers;

use core\Controller;
use core\Application;
use core\Request;
use models\Paste;
use models\User;
use core\exception\ForbiddenException;
use models\Membership;

class UpdateController extends Controller
{
    public function handleUpdate(Request $request, $record)
    {
        if ($request->getMethod() === "get") {

            ///middleware !! 
            if (!(Application::$app->isOwner($record->id_user) || Application::$app->isMember($record->id))) {
                throw new ForbiddenException();
            }
            $membership = new Membership();

            if (!$this->validateMembership($request, $record)) {
                Application::$app->response->redirect('/' . $record->slug);
                exit;
            }
            $membership->loadData($this->getBodyFromEmail($request, $record));

            /// make validation
            if ($membership->save()) {
                Application::$app->session->setFlash('success', 'You added a new member to modify your post');
            }
            Application::$app->response->redirect('/' . $record->slug);
            exit;
        }
    }

    private function getBodyFromEmail(Request $request, $record)
    {
        $email = $request->getBody()['email'];
        $id_paste = $record->id;
        $sql = sprintf("SELECT id FROM users WHERE email = '%s'",  $email);
        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $object = $statement->fetchObject();
        $id_user = $object->id;
        $output = [];
        $output['id_paste'] = $id_paste;
        $output['id_user'] = $id_user;
        return $output;
    }

    public function validateMembership($request, $record)
    {
        ///find the id  
        /// check if the email is valid 
        $email = $request->getBody()['email'];
        $sql = sprintf("SELECT id FROM users WHERE email = '%s'", $email);
        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();

        $object = $statement->fetchObject();
        /// if the email is not valid 
        if ($object == false) {
            return false;
        }
        /// if the collaborator is the owner
        if ($object->id == Application::$app->user->id) {
            Application::$app->session->setFlash('error', 'You are the owner of this post!');
            return false;
        }

        /// if the membership is already added 
        $sql = sprintf("SELECT COUNT(*) AS counter FROM members WHERE id_paste = '%s' AND id_user = '%s'", $record->id, $object->id);

        $statement =  Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject();
        if ($result->counter > 0) {
            Application::$app->session->setFlash('error', 'You allready added this user !');
            return false;
        }
        /// al good, the membership can be added!

        return true;
    }
}
