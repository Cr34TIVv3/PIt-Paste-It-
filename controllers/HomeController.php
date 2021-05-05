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
        if( $request->getMethod() === "post")
        {
            
            $paste->loadData($request->getBody());
            
            // var_dump(get_object_vars($paste));
           
            if($paste->validate() && $paste->submit())
            {
                //display message 
              
                // Application::$app->session->setFlash('success', 'Welcome');
                echo "salut";
                Application::$app->response->redirect('/preview/'.$paste->slug);
                exit;
            }

             return $this->render('home');
        }
        else 
        {
          return $this->render('home');
        }
  }

     
}