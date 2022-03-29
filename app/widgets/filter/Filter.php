<?php

namespace app\widgets\filter;

use ishop\Cache;

class Filter
{
    //нам потребуются два свойства
    public $groups; // отвечает за группы
    public $attrs;  // отвечает за атрибуты
    public $tpl;    // путь к шаблону

    public function __construct()
    {
        $this->tpl = __DIR__ . '/filter_tpl.php'; // путь к шаблону
        $this->run();
    }


    protected function run()
    {
        $cache = Cache::instance();
        $this->groups = $cache->get('filter_group');  // по ключу 'filter_group' 

        // если ничего не получили из КЭШа
        if (!$this->groups) {

            $this->groups = $this->getGroups(); // значит должны получить из БД 
            $cache->set('filter_group', $this->groups, 30); // и за КЭШировать

        }


        $this->attrs = $cache->get('filter_attrs');

        if (!$this->attrs) {

            $this->attrs = self::getAttrs(); // значит должны получить из БД 
            $cache->set('filter_attrs', $this->attrs, 30); // и за КЭШировать

        }
        // debug($this->groups);
        // debug($this->attrs);

        $filters = $this->getHtml();
        echo $filters;
    }



    // метод для получения HTML кода 
    protected function getHtml()
    {
        ob_start(); // буферизация

        // возвращает строку через запятую с фильтрами
        $filter = self::getFilter();
        if (!empty($filter)) {
            $filter = explode(',', $filter);
        }

        require $this->tpl; //подключаем шаблон

        return ob_get_clean(); // возвращаем данные их буфера, очищая этот самый буфер
    }


    protected function getGroups()
    {
        return \R::getAssoc('SELECT id, title FROM attribute_group');
    }


    protected static function getAttrs()
    {
        $data = \R::getAssoc('SELECT * FROM attribute_value');

        // для вывода фильтров
        $attrs = [];
        foreach ($data as $k => $v) {
            $attrs[$v['attr_group_id']][$k] = $v['value'];
        }

        return $attrs;
    }

    // для обработки переменной $filter
    // возвращает строку через запятую с фильтрами
    public static function getFilter()
    {
        $filter = null;
        if (!empty($_GET['filter'])) {
            // нас интересует что бы в строке были только цифры и запятыи
            $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
            // далее обрежим запятую в конце  
            $filter = trim($filter, ','); // обрежит по бокам запятую
        }
        return $filter; // если условие не сработает, то вернётся null
    }


    public static function getCountGroups($filter)
    {
        // получим массив из строки
        $filters = explode(',', $filter);
        $cache = Cache::instance();
        $attrs = $cache->get('filter_attrs');
        //если у КЭШе нет атрибутов
        if (!$attrs) {
            $attrs = self::getAttrs();
        }
        $data = [];
        foreach ($attrs as $key => $item) {
            foreach ($item as $k => $v) {
                //если есть в массиве $k
                if (in_array($k, $filters)) {
                    $data[] = $key;
                    break;
                }
            }
        }
        return count($data);
        // debug($data);
        // debug($filters);
        // debug($attrs);
    }
}
