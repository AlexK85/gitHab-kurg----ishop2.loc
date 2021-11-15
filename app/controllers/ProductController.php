<?php

namespace app\controllers;

use app\models\Product;

class ProductController extends AppController
{
    
    // будет только один ЭКШН
    public function viewAction()
    {
        // debug($this->route);
        $alias = $this->route['alias'];
        //далее нам нужна информация по запрошенному продукту
        // 'product' - обращение к таблице, 'alias = ?' - нас интересует продукт по alias. А т.к. данные пользовательские защищаем SQL инъекцией. [$alias] - будет подставлен в подготовленное выражение
        $product = \R::findOne('product', "alias = ? AND status = '1'", [$alias]);
        // debug($product);
        if (!$product) {
             // выбрасываем исключение 
             throw new \Exception('Страница не найдена', 404);
        }



        // хлебные крошки



        // связанные товары
        $related = \R::getAll("SELECT*FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);
        // debug($related );


        // запись в куки запрошенного товара
        $p_model = new Product();
        $p_model->setRecentlyViewed($product->id);


        // просмотренные товары
        $r_viewed = $p_model->getRecentlyViewed();
        // debug($r_viewed);
        $recentlyViewed = null;

        // если $r_viewed будем доставать эти товары из БД и класть их в $recentlyViewed
        if ($r_viewed) {
            $recentlyViewed = \R::find('product', 'id IN (' . \R::genSlots($r_viewed) . ') LIMIT 3', $r_viewed);
        }
        // debug($recentlyViewed);



        // галерея
        $gallery = \R::findAll('gallery', 'product_id = ?', [$product->id]);
        // debug($gallery);


        //  модификации товара



        // установим методанные страницы
        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product', 'related', 'gallery', 'recentlyViewed'));
    }

}