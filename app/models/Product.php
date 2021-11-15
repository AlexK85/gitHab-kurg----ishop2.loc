<?php

namespace app\models;

use app\models;

class Product extends AppModel
{

    // добавляет просмотренный товар
    public function setRecentlyViewed($id)
    {
        // Получим все товары, которые есть в КУКАХ которые когда либо смотрел пользователь
        $recentlyViewed = $this->getAllRecentlyViewed();
        if (!$recentlyViewed) {
            setcookie('recentlyViewed', $id, time() + 3600 * 24, '/');
        } else {
            $recentlyViewed = explode('.', $recentlyViewed);

            // если $id нет в $recentlyViewed
            if (!in_array($id, $recentlyViewed)) {
                $recentlyViewed[] = $id;
                // теперь два товара соединяем  
                $recentlyViewed = implode('.', $recentlyViewed);
                // полученную строку записываем в КУКИ
                setcookie('recentlyViewed', $recentlyViewed, time() + 3600 * 24, '/');
            }
            // debug($recentlyViewed);
        }
    }


    public function getRecentlyViewed()
    {
        if (!empty($_COOKIE['recentlyViewed'])) {
            $recentlyViewed = $_COOKIE['recentlyViewed']; 
            // по разделителю '.' формируем массив
            $recentlyViewed = explode('.', $recentlyViewed);

            // вернём ТРИ продукьта из массива с конца 
            return array_slice($recentlyViewed, -3);
        }
        return false;
    }


    public function getAllRecentlyViewed()
    {
        if (!empty($_COOKIE['recentlyViewed'])) {

            return $_COOKIE['recentlyViewed'];
        }

        // в противном случае вепнём
        return false;
    }
}
