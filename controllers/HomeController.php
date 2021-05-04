<?php 

namespace controllers;
use core\Controller;
use core\Request;

class HomeController extends Controller
{
  public function handleHome(Request $request)
  {
    // $login = new Login();
        if( $request->getMethod() === "post")
        {
            
            $data->loadData($request->getBody()); 
           
            if($data->validate() && $data->submit())
            {
                //display message 
              
                // Application::$app->session->setFlash('success', 'Welcome');
                Application::$app->response->redirect('/home');
                exit;
            }

            return $this->render('signin', ['model' => $login]);
        }
        else 
        {
          return $this->render('home');
        }
      
  }

     
}