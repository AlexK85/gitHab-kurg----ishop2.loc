<?php

// var_dump($_SERVER['QUERY_STRING']);

require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS . '/functions.php';
require_once CONF . '/routes.php'; // тут подключаем массив маршрутов 

new \ishop\App();

// Так же в любой момент мы можем положить в этот контейнер в самом коде что-то...
//допустим положим некоторое значение 'test' со строкой 'TEST'
// \ishop\App::$app->setProperty('test', 'TEST');

// var_dump(\ishop\App::$app->getProperties());
// debug(\ishop\App::$app->getProperties()); // это для красивой распечатки

// выбросим какое либо исключение
// throw new Exception('Страница не найдена', 404); 


// debug(\ishop\Router::getRoutes());
