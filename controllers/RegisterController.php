<?php 

namespace controllers;

use core\Controller;
use core\Request;
use models\User;


class RegisterController extends Controller{
   

    public function handleRegistration(Request $request) {
        $user = new User();
        if( $request->getMethod() === "post")
        {
            
            $user->loadData($request->getBody()); 

            if($user->validate() && $user->save())
            {
                return 'Succes'; 
            }

            return $this->render('signup', ['model' => $user]);
        }
        else 
        {
            // echo "pas 1: ";
            return $this->render('signup', ['model' => $user]);
        }
    }




}