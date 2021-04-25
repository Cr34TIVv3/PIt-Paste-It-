<?php 

namespace controllers;
use core\Application;
use core\Controller;
use core\Request;

class HomeController extends Controller
{
  public function handleHome(Request $request)
  {
      return $this->render('home');
  }

     
}