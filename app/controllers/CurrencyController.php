<?php

namespace app\controllers;


class CurrencyController extends AppController
{

    public function changeAction() 
    {
        // если у нас не пуст $_GET['curr'] тогда мы возьмём его значение $_GET['curr'] в противном случае в переменную  $currency запишем null
        $currency = !empty($_GET['curr']) ? $_GET['curr'] : null;
        if ($currency) {
            $curr = \R::findOne('currency', 'code = ?', [$currency]);
            // если у нас не пуст объект $curr
            if (!empty($curr)) {
                // в этом случае мы эту валюту должны записать в КУКИ
                // создаём КУКУ 'currency' в неё записываем полученную валюту $currency на какое время и для всего домена '/'
                setcookie('currency', $currency, time() + 3600*24*7, '/');
            }
        }
        // далее нам необходимо перезапросить страницу
        redirect();
    }

}