<?php

namespace ishop;

class Router
{
    // определим некие свойства и пару методов
    public static $routes = []; // тут будет храниться таблица маршрутов. Сюда мы будем записывать имеющиеся маршруты на нашем сайте
    public static $route = [];  // будет храниться текущий маршрут если найдено соответствие 



    // Создадим методы далее...
    // данный метод будет записывать привила в таблицу маршрутов
    public static function add($regexp, $route = []) // $regexp - это регулярные выражения
    {
        //запишем в таблицу маршрутов с ключом $regexp соответствие для данного маршрута
        self::$routes[$regexp] = $route;
    }



    // Эти методы нужны что бы увидеть, что всё работает
    // Далее запишим метод для тестирования 
    public static function getRoutes()
    {
        return self::$routes;  // Он возвращает таблицу маршрутов
    }




    // Возвращает текущий маршрут
    public static function getRoute()
    {
        return self::$route;
    }




    public static function dispatch($url)
    {
        $url = self::removeQuerySrting($url);
        // var_dump($url);
        if (self::matchRoute($url)) {
            // echo 'Ok';
            // Если найдено соответствие мы должны вызвать некий контроллер
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';

            // А если у нас такой класс автозагрузчик по  имени контроллера попытается найти соответстующее имя файла
            // соответствующий файл подключить его  
            // Если существует такой класс контроллер
            if (class_exists($controller)) {
                $controllerObject = new  $controller(self::$route); // 1.Создаётся объект контроллера 
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                // Теперь нам остаётся только проверить, а есть ли такой метод у данного объекта в данном классе
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action(); // 2.Вызывается метод контроллера
                    $controllerObject->getView(); // 3.Вызывается метод getView() базового контроллера
                } else {
                    throw new \Exception("Метод $controller::$action не найден", 404);
                }
            } else {
                throw new \Exception("Контроллер $controller не найден", 404);
            }
        } else {
            // echo 'No';
            throw new \Exception("Страница не найдена", 404);
        }
    }




    // Будет искать соответствие таблицы маршрутов
    public static function matchRoute($url)
    {
        // У нас есть таблица маршрутов в свойстве $routes
        // Пройдёмся в цикле по self::$routes
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $url, $matches)) {
                // debug($matches);
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }
                // Обработаем имя контроллера
                $route['controller'] = self::upperCamelCase($route['controller']);

                self::$route = $route;
                // debug(self::$route);

                return true;
            }
        }

        return false;
    }




    // Создадим несколько служебных методов

    // CamelCase (Служит для изменения наименований имён КОНТРОЛЛЕРОВ)
    protected static function upperCamelCase($name)
    {
        // Мы ввели в адресную строку page-new, а на странице будет  page new. За тем ucwords и получили Page New
        // Затем str_replace() мы ищем пробел ' ' и заменяем его на пустую строку '' в ucwords(str_replace('-', ' ', $name)
        // Мы получим два слова склеяных вместе PageNew
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
        // debug($name);
    }

    // camelCase (Служит для изменения наименований имён ЭКШНОВ)
    protected static function lowerCamelCase($name)
    {
        // lcfirst() сделает первую букву маленькой и получим нужный формат
        return lcfirst(self::upperCamelCase($name));
    }



    // вырезаем из строки запроса GET параметры
    protected static function removeQuerySrting($url)
    {
        // var_dump($url);
        if ($url) {
            // Разделим ГЕТ параметры на две части: по символу & в $url и ограничим на две части 
            $params = explode('&', $url, 2);
            // debug($params);

            if (false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
    }
}
