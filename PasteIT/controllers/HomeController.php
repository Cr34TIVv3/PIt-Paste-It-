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

      $paste->setCaptchaAnswer(Application::$app->session->get('captcha_text'));

      /// calculate the expiration date ! 

      $sqltime = date('Y-m-d H:i:s');

      $sqltime = date('Y-m-d H:i:s', strtotime($sqltime . ' + ' . $paste->expiration));
      $paste->expiration = $sqltime;

      if ($paste->validate() && $paste->submit()) {
        Application::$app->response->redirect('/' . $paste->slug);
        exit;
      }
      return $this->render('home', ['model' => $paste]);
    } else {
      return $this->render('home', ['model' => $paste]);
    }
  }
}
