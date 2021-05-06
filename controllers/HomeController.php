<?php

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use models\Paste;

class HomeController extends Controller
{
  public function handleHome(Request $request)
  {
    $paste = new Paste();
    if ($request->getMethod() === "post") {
      $paste->loadData($request->getBody());
      $paste->setCaptchaAnswer($_SESSION['captcha_text']);
      // var_dump(get_object_vars($paste));

      if ($paste->validate() && $paste->submit()) {
        // Application::$app->session->setFlash('success', 'Welcome');
        Application::$app->response->redirect('/' . $paste->slug);
        exit;
      }

      return $this->render('home');
    } else {
      return $this->render('home');
    }
  }
}
