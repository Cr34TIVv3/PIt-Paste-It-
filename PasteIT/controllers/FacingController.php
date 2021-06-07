<?php


namespace controllers;

use core\Controller;
use core\Request;

class FacingController extends Controller
{
   public function handleFacing()
   {
      return $this->render('facing');
   }
}
