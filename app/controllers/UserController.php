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

            if (!$user->validate($data) || !$user->checkUnique()) {
                // echo 'NO';
                debug($user->errors);
                $user->getErrors();
                $_SESSION['form_data'] = $data;
                // redirect();
            } else {
                // echo 'OK';
                // $_SESSION['success'] = 'OK';
                // для скрытия хеша в поле password в БД
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                if ($user->save('user')) {
                    $_SESSION['success'] = 'Пользователь зарегестрирован';
                } else {
                    $_SESSION['error'] = 'Ошибка!';
                }
                // $_SESSION['success'] = 'Пользователь зарегестрирован';
                // redirect();
            }
            // die;
            redirect();
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
