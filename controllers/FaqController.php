<?php


namespace controllers;
use core\Controller;
use core\Request;

class FaqController extends Controller
{

    public function handleFaq(Request $request)
    {
        return $this->render('faq');
    }


}