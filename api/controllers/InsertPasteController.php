<?php

namespace controllers;

use core\Controller;
use core\Request;
use core\Response;
use models\Paste;

class InsertPasteController extends Controller
{
    public function handleInsert(Request $request, Response $respone)
    {

        $paste = new Paste(); 
        $data = json_decode(file_get_contents("php://input"));
        $paste->loadData($data); 



        var_dump($_POST);
        // var_dump($_POST);
        
    }
}
