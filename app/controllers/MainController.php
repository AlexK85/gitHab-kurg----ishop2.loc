<?php

namespace app\controllers;

// use ishop\App;
use ishop\Cache;  // для вывода - $cache = Cache::instance();

class MainController extends AppController
{

    public function indexAction()
    {

        // Со 2 части курса
        $brands = \R::find('brand', 'LIMIT 3'); // будем ПОЛУЧАТЬ/выводить 3 бренда 
        // debug($brands);


        // Со 2 части курса
        $hits = \R::find('product', "hit = '1' AND status = '1' LIMIT 8");


        // $posts = \R::findAll('test');
        // debug($posts);
        // $post = \R::findOne('test', 'id = ?', [2]); // выводит из таблицы test вторую запись
        // debug($post);

        // это нужно и для 2 части курса
        $this->setMeta('Главная страница', 'Описание...', 'Ключевики...'); 


        // Со 2 части курса
        $this->set(compact('brands', 'hits')); // так мы передаём бренды в ВИД/ представление


        // Нименование сайта можно взять из контейнера config/params.php
        // $this->setMeta(App::$app->getProperty('shop_name'), 'Описание...', 'Ключевики...'); 



        //  Можно передавать т
        // $name = 'John';
        // $age = 30;
        // $names = ['Andrey', 'Jane', 'Mike'];

        // $cache = Cache::instance();
        // // $cache->set('test', $names);

        // // $cache->delete('test');

        // // теперь прочитаем данные из КЕШа
        // $data = $cache->get('test');

        // if (!$data) {
        //     $cache->set('test', $names);
        // } 

        // debug($data); 

        // $this->set(compact('name', 'age', 'names', 'posts'));  // добавим posts и теперь можно работать с ним в виде views/Main/index.php
    }
}
  