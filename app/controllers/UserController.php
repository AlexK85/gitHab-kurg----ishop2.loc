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
            // debug($user);

            if (!$user->validate($data)) {
                echo 'NO';
            } else {
                echo 'OK';
            }
            die;
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
