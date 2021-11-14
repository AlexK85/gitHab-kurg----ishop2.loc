<?php
// создадим служебную функцию для ДЕБАГА
function debug($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}




function redirect($http = false) {
    // Если пользователь что-то передал в функцию redirect
    if ($http) {
        // мы сделаем redirect на него 
        $redirect = $http;
    }else {
        // Если пользователь ничего не передал. Отправить пользователя туда от куда он пришёл. Если такогого нет, то отправим пользователя на главную страницу при помощи константы PATH
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    // и в итоге функция сделает редирект по сформированному адресу, который получился в переменной $redirect
    header("Location: $redirect");
    exit;
}
