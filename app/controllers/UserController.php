<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController
{

    public function signupAction()
    {
        //если не пусто
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load($data);
            // debug($user->attributes);

            if (!$user->validate($data)) {
                // echo 'NO';
                debug($user->errors); 
                $user->getErrors();
                redirect();
            } else {
                // echo 'OK';
                $_SESSION['success'] = 'OK';
                redirect();
            }
            // die;
        }
        $this->setMeta('Регистрация');
    }


    public function loginAction()
    {
    }


    public function logoutAction()
    {
    }
}
