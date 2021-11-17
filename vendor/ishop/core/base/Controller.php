<?php

namespace ishop\base; // Пространство имён

abstract class Controller
{
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];  // Хронятся обычные данные
    public $meta = ['title' => '', 'desc' => '', 'keywords' => ''];  // Хронятся мета данные

    public function __construct($route)  // $route параметр мершрут, который передаётся их класса маршрутизатора
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $route['action'];
        $this->prefix = $route['prefix'];
    }


    
    // Метод вызывает объект вида и будет вызывать данный метод рендер 
    public function getView()
    {
        // Получить объект вида 
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
    }



    // Суть этого метода в том, что бы поместить в массив $data = [] некоторые данные
    public function set($data)
    {
        $this->data = $data;
    }

    // Этот метод для методанных
    public function setMeta($title = '', $desc = '', $keywords = '')
    {
        $this->meta['title']  = $title;
        $this->meta['desc']  = $desc;
        $this->meta['keywords']  = $keywords;
    }
}
