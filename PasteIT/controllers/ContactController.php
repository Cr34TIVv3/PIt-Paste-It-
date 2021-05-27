<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;

class ContactController extends Controller
{
  public function handleContact(Request $request)
  {
    return $this->render('contact');
  }
}
