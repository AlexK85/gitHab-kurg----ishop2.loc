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

        // запись в куки запрошенного товара

        // просмотренные товары

        // галерея

        //  модификации товара

        // установим методанные страницы
        $this->setMeta($product->title, $product->description, $product->keywords);
        $this->set(compact('product'));
    }

}