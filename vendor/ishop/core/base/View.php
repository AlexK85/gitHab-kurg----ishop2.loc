<?php

namespace ishop\base;

use Exception;

class View
{
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = [];

    public function __construct($route, $layout = '', $view = '', $meta)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->view = $view;
        $this->model = $route['controller'];
        $this->prefix = $route['prefix'];
        $this->meta = $meta;
        // Если выключен шаблон мы в свойство $this->layout запишем  false

        if ($layout === false) {
            $this->layout = false;
        } else {
            // Если передан какой то шаблон мы возмём его, 
            // в противном случае если передана пустая строка Тогда мы возмём значение константы LAYOUT
            $this->layout = $layout ?: LAYOUT;
        }
    }


    // Этот метод будет формировать или рендорить страничку для поьзователя
    public function render($data)
    {
        // debug($data);
        if (is_array($data)) extract($data);
        // далее нам нужно сформировать путь к LAYOUT (путь к шаблону) и путь к виду
        $viewFile =  APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php"; // путь к виду
        if (is_file($viewFile)) {
            ob_start(); // включим буферизацию
            require_once $viewFile;
            // Вернём всё из буфера в переменную $content
            $content = ob_get_clean();  // если $content вывести, то из vievs/Main/index.php
        } else {
            // мы должны выбросить исключение, что не найден таковой вид
            throw new \Exception("Не найден вид {$viewFile}", 500);
        }

        // Теперь нам необходимо подключить шаблон 
        // Но только если свойство $this->layout не равняется false
        if (false !== $this->layout) {
            // Сформируем путь к файлу
            $layoutFile = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \Exception("Не найден шаблон {$this->layout}", 500);
            }
        }
    }



    public function getMeta()
    {
        $output = '<title>' . $this->meta['title'] . '</title>' . PHP_EOL; // PHP_EOL вернёт корректный символ переноса строки
        $output .= '<meta name="description" content="' . $this->meta['desc'] . '">' . PHP_EOL;
        $output .= '<meta name="keywords" content="' . $this->meta['keywords'] . '">' . PHP_EOL;
        return $output;
    }
}
