<?php


namespace controllers;
use core\Controller;
use core\Request;

class FacingController extends Controller
{
   public function handleFacing(Request $request)
   {
        return $this->render('facing');

   }



}