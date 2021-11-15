<?php

namespace app\controllers;


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



        // просмотренные товары



        // галерея
        $gallery = \R::findAll('gallery', 'product_id = ?', [$product->id]);
        // debug($gallery);


        //  модификации товара



        // установим методанные страницы
        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product', 'related', 'gallery'));
    }

}