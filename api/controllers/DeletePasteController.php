<?php

namespace controllers;

use core\Controller;
use core\Request;
use core\Response;
use Exception;
use models\Paste;

class DeletePasteController extends Controller
{
    public function handleDelete(Request $request, Response $respone)
    {
        $paste = new Paste(); 
        $data = json_decode(file_get_contents("php://input"));
        $paste->loadData($data); 
        try {
            $paste->delete();
        }
        catch (Exception $e) {
            echo json_encode(["response" => "Something went wrong!"]);
            $respone->setStatusCode(400);
            exit;
        }
        echo json_encode(["response" => "Records deleted"]);
    }
}
