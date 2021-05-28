<?php


namespace controllers;

use core\Controller;

class FaqController extends Controller
{

    public function handleFaq()
    {
        return $this->render('faq');
    }
}
