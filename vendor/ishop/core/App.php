<?php

namespace ishop;

class App
{
    public static $app;

    public  function __construct()
    {
        // строка запроса попадает в переменную $query 
        $query = trim($_SERVER['QUERY_STRING'], '/');
        session_start();

        // self::$app - это контейнер, в котором записан объект нашего реестра
        self::$app = Registry::instance();
        $this->getParams();
        new ErrorHandler(); // это что бы все исключения обработал обработчик
        Router::dispatch($query);
    }

    // это защищённый метод, кторый будет получать все настройки 
    protected function getParams()
    {
        // CONF - ведёт к папке config
        $params = require_once CONF . '/params.php'; // В переменной $params находится массив, который в этом файле params.php
        // Если у нас не пуст массив $params
        if (!empty($params)) {
            foreach ($params as $k => $v) {
                // И кладём в контейнер 
                self::$app->setProperty($k, $v);
            }
        }
    }
}
