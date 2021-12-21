<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
// use ishop\App;


class CategoryController extends AppController
{

    public function viewAction()
    {
        // Получаем $alias
        // debug($this->route);
        $alias = $this->route['alias'];
        // debug($alias);
        // die;

        // запрос к БД к таблице категории
        $category = \R::findOne('category', 'alias = ?', [$alias]);
        // debug($category);
        // die;

        // Далее проверяем если мы не достали $category тогда выбрасываем исключение! 
        if (!$category) {
            throw new \Exception('Страница не найдена', 404);
        }
        // echo 'OK';
        // die;

        // Далее получим ХЛЕБНЫЕ КРОШКИ
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category->id);


        $cat_model = new Category();
        echo $ids = $cat_model->getIds($category->id);
        // debug(App::$app->getProperty('cats'));
        // var_dump($ids);  // выедет NULL 
        $ids = !$ids ? $category->id : $ids . $category->id;
        // die;

        // получаем продукты
        $products = \R::find('product', "category_id IN ($ids)");
        // debug($products);

        // передадим теперь все данные в ВИД
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs')); // данные для представления
    }
}
