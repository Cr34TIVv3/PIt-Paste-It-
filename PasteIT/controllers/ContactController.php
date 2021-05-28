<?php

namespace controllers;

use core\Controller;

class ContactController extends Controller
{
  public function handleContact()
  {
    return $this->render('contact');
  }
}
