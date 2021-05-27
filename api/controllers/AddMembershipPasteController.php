<?php

namespace controllers;

use core\Controller;
use core\Request;
use core\Response;
use models\Membership;
use Exception;

class AddMembershipPasteController extends Controller
{
    public function handleInsert(Request $request, Response $respone)
    {
        $membership = new Membership();
        $data = json_decode(file_get_contents("php://input"));
        $membership->loadData($data);
        try {
            $membership->save();
        } catch (Exception $e) {
            echo json_encode(["response" => "Something went wrong!"]);
            $respone->setStatusCode(400);
            exit;
        }
        echo json_encode(["response" => "Membership added"]);
    }
}
