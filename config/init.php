<?php

// определим несколько констант
define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/ishop/core');
define("LIBS", ROOT . '/vendor/ishop/core/libs');
define("CACHE", ROOT . '/tmp/cache');
define("CONF", ROOT . '/config');
define("LAYOUT", 'watches'); // Шаблон нашего сайта watches из 1 части тестовый шаблон по умолчанию default

date_default_timezone_set('Europe/Moscow');

// http://my_progect_php.com/ishop2.loc/public/index.php
$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";

// http://my_progect_php.com/ishop2.loc/public/
$app_path = preg_replace("#[^/]+$#", '', $app_path);

// http://my_progect_php.com/ishop2.loc
$app_path = str_replace('/public/', '', $app_path);

define("PATH", $app_path);
define("ADMIN", PATH . '/admin');

// Подключается автозагрузчик КОМПОЗЕРА
require_once ROOT . '/vendor/autoload.php';
