<?php

namespace app\models;

use ishop\App;

class Breadcrumbs
{

    // тут будем получать ХЛЕБНЫЕ КРОШКИ отдавать их
    public static function getBreadcrumbs($category_id, $name = '')
    {
        // Получим все категории
        $cats = App::$app->getProperty('cats');
        $breadcrumbs_array = self::getParts($cats, $category_id);
        // БУдем проходиться в цикле по массиву $breadcrumbs_array и формировать ссылки на каждый элемент массива 
        $breadcrumbs = "<li><a href='" . PATH . "'>Главная</a></li>";
        if ($breadcrumbs_array) {
            foreach ($breadcrumbs_array as $alias => $title) {
                $breadcrumbs .= "<li><a href='" . PATH . "/category/{$alias}'>{$title}</a></li>";
            }
        }

        if ($name) {
            // допишем в $breadcrumbs ещё один элемент массива (будет идти не ссылкой А ЭЛЕМЕНТ МАССИВА)
            $breadcrumbs .= "<li>$name</li>";
        }

        return $breadcrumbs;
        // debug($breadcrumbs_array);
    }

    // служебный метод 
    public static function getParts($cats, $id)
    {
        // debug($id);
        // debug($cats);

        // Если у нас нет $id  текущей категории
        if (!$id) return false;

        $breadcrumbs = [];

        foreach ($cats as $k => $v) {
            if (isset($cats[$id])) {
                $breadcrumbs[$cats[$id]['alias']] = $cats[$id]['title'];
                // теперь ищем элемент следующего родителя
                $id = $cats[$id]['parent_id'];
            } else break;
        }

        return array_reverse($breadcrumbs, true);
    }
}
