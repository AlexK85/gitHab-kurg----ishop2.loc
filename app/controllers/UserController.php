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


    // сюда уходят данные введённый пользователем после ввода данных в форму login.php
    public function loginAction()
    {
        // Если у нас приходят на эту страницу данные ПОСТОМ
        // Если не пуст массив POST
        if (!empty($_POST)) {
            //Создадим объект пользователя 
            $user = new User();
            if ($user->login()) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
            } else {
                $_SESSION['error'] = 'Логин/пароль введены неверно';
            }
            redirect();
        }
        // Установили метаданные
        $this->setMeta('Вход');
    }

    // метод для выхода из авторизации
    public function logoutAction()
    {
        // если существует в $_SESSION['user'] тогда его удалим.
        if (isset($_SESSION['user'])) unset($_SESSION['user']);
        redirect();
    }
}
