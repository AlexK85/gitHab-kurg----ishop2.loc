<?php

namespace app\widgets\currency;
// namespace app\views\layouts\watches;


use ishop\App;



class Currency
{

    protected $tpl;  // для формирования выпадающего списка, тут будет использован шаблон
    protected $currencies;  // список всех доступных валют
    protected $currency;  // активная для пользователя валюта

    public function __construct()
    {
        // __DIR__ - это текщее расположение файла
        $this->tpl = __DIR__ . '/currency_tpl/currency.php';
        $this->run();
    }

    // метод будет получать список доступных валют и получать текущую валюту. На основе этих данных будет строить HTML код
    protected function run()
    {
        $this->currencies = App::$app->getProperty('currencies');
        $this->currency = App::$app->getProperty('currency');

        echo $this->getHtml();
    }

    // получает СПИСОК ВАЛЮТ 
    public static function getCurrencies()
    {
        return \R::getAssoc("SELECT code, title, symbol_left, symbol_right, value, base FROM currency ORDER BY base DESC");
    }

    // получает АКТИВНУЮ ВАЛЮТУ
    public static function getCurrency($currencies)
    {
        // array_key_exists проверит существование элемента в некотором массиве
        if (isset($_COOKIE['currency']) && array_key_exists($_COOKIE['currency'], $currencies)) {
            $key = $_COOKIE['currency'];
        } else {
            $key = key($currencies);
        }
        $currency = $currencies[$key];
        $currency['code'] = $key;

        return $currency;
    }

    protected function getHtml()
    {
        ob_start(); // Буферезация, что бы не выводился шаблон

        // Подключаем шаблон
        require_once $this->tpl;

        return ob_get_clean(); // что бы вернулось в переменную
    }
}
