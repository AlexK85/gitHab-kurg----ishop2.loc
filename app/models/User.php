<?php

namespace app\models;

class User extends AppModel
{
    // массив свойств модели
    public $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'address' => '',
    ];

    // массив правил
    public $rules = [
        'required' => [
            ['login'],
            ['password'],
            ['name'],
            ['email'],
            ['address'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['password', 6],
        ]
    ];

    // проверка уникальности пароля
    public function checkUnique()
    {
        $user = \R::findOne('user',  'login = ? OR email = ?', [$this->attributes['login'], $this->attributes['email']]);
        // Если мы вытащили пользователя
        if ($user) {
            if ($user->login  == $this->attributes['login']) {
                $this->errors['unique'][] = 'Этот логин уже занят!';
            }
            if ($user->email  == $this->attributes['email']) {
                $this->errors['unique'][] = 'Этот email уже занят!';
            }
            return false;
        }
        return true;
    }

    public function login($isAdmin = false)
    {
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;

        if ($login && $password) {
            if ($isAdmin) {
                // нужно найти одного пользователя findOne() в таблице user где поле login = ? AND role = 'admin', а значение мы берём из [$login]
                $user = \R::findOne('user', "login = ? AND role = 'admin'", [$login]);
            } else {
                $user = \R::findOne('user', "login = ?", [$login]);
            }

            // Если мы достали по логину пользователя
            if ($user) {
                //тогда проверим пароль пользователя: 1 параметр - передаём полученный пароль, 2 параметр - строку, с которой сравниваем, если мы достанем пользователя.
                if (password_verify($password, $user->password)) {
                    foreach ($user as $k => $v) {
                        if ($k != 'password') $_SESSION['user'][$k] = $v;
                    }
                    return true;
                }
            }
        }

        return false;
    }

    //  проверим авторизован ли новый пользователь или нет 
    public static function checkAuth()
    {
        return isset($_SESSION['user']);
    }

    // проверка роли пользователя
    public static function isAdmin()
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }
}
