<?php

namespace app\widgets\menu;
// namespace ishop;

use ishop\Cache;
use ishop\App;

class Menu
{

     protected $data; // для данных
     protected $tree; // массив дерева, который будем строить из данных
     protected $menuHtml; // готовый HTML код нашего меню
     protected $tpl; // хранится шаблон, который необходимо использовать для меню
     protected $container = 'ul'; 
     protected $class = 'menu'; 
     protected $table = 'category'; // таблица в базе данных  в которой необходимо выбирать эти данные 
     protected $cache = 3600; // на какое время хотим кЭШИРОВАТЬ данные
     protected $cacheKey = 'ishop_menu'; // ключ под которым будут сохраняться данные в файл КЭША
     protected $attrs = []; // массив дополнительных атрибутов для меню
     protected $prepend = ''; // потребуется в админке // строка, которую пользователь может захотеть по задумке вставить



     public function __construct($options = [])
     {
         $this->tpl = __DIR__ . '/menu_tpl/menu.php';
         // закинем в настройки переданные из настроек виджета в соответсвующие им свойства 
         $this->getOptions($options);
        //  debug($this->table);
         $this->run();
     }



     // для получения ОПЦИЙ 
     // параметром будет принимать некие настройки и заполнять свойства выше, которые мы даём пользователю
     protected function getOptions($options)
     {
         // проходимся в цикле по нашим переданным настройкам     ЭТО КЛЮЧ 'tpl' =>     ЭТО ЗНАЧЕНИЕ  WWW . '/menu/menu.php'
          foreach ($options as $k => $v) {
            // если у нас существует ключ в свойствах нашего класса, 
            if (property_exists($this, $k)) {
                // тогда возьмём данное свойство и заполним его значением
                $this->$k = $v;
            }
          }
     }


     // начнёт формировать МЕНЮ
     protected function run()
     {
          $cache = Cache::instance();
          $this->menuHtml = $cache->get($this->cacheKey);
          if (!$this->menuHtml) {
            // пытаемся получить данные в свойства $data
            $this->data = App::$app->getProperty('cats');
            // если у нас данные не получены
            if (!$this->data) {
                $this->data = $cats = \R::getAssoc("SELECT * FROM {$this->table}");
            }
            // debug($this->data);
            $this->tree = $this->getTree();
            // debug($this->tree);
            $this->menuHtml = $this->getMenuHtml($this->tree);
            //если передан КЭШ
            if ($this->cache) {
                // тогда будем меню КЭШировать
                $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
            }
          }

          $this->output();
     }


     protected function output()
     {
        $attrs = '';
        // debug($this->attrs);
        if (!empty($this->attrs)) {
            foreach ($this->attrs as $k => $v) {
                $attrs .= " $k='$v' ";
            }
        }
        echo "<{$this->container} class='{$this->class}' $attrs>";
            echo $this->prepend; 
            echo $this->menuHtml;
        echo "</{$this->container}>";
     }


     // метод получающий дерево из ассоциативного массива
     protected function getTree()
     {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id=>&$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            }else {
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }

        return $tree; 
     }


     // метод получающий HTML код. Принимает в себя 1 параметром УЧАСТОК дерева иразделитель 
     protected function getMenuHtml($tree, $tab = '')
     {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }

        return $str;
     }


     //  возьмём какую то категорию и по шаблону из неё сформируем кусочек HTML кода 
     protected function catToTemplate($category, $tab, $id)
     {
        ob_start();
        require $this->tpl;

        return ob_get_clean();
     }
}