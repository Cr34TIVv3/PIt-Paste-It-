<?php
namespace controllers;
use core\Controller;
use models\Paste;


class DeleteController extends Controller
{
    public function handleDelete($record)
    {   
        $updatedPaste = new Paste();
        $updatedPaste->delete($record);
    }
}
