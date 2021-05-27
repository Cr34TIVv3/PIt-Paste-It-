<?php

namespace controllers;

use core\Controller;
use core\Request;
use core\Response;
use Exception;
use models\Paste;

class InsertPasteController extends Controller
{
    public function handleInsert(Request $request, Response $respone)
    {
        $paste = new Paste(); 
        $data = json_decode(file_get_contents("php://input"));
        $paste->loadData($data); 

        try {
            $paste->save();
        }
        catch (Exception $e) {
            echo json_encode(["response" => "Something went wrong!"]);
        }

        echo json_encode(["response" => "Done"]);
    }
}
