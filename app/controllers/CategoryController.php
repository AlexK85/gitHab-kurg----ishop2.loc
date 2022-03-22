<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use ishop\App;
use ishop\libs\Pagination;

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
        $ids = $cat_model->getIds($category->id);
        // debug(App::$app->getProperty('cats'));
        // var_dump($ids);  // выедет NULL 
        $ids = !$ids ? $category->id : $ids . $category->id;
        // die;



        // Нужно для получения постраничной навигации! 

        // var_dump(App::$app->getProperty('pagination'));
        // Если есть номер страница, то берём его, если нет тогда это будет 1 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = App::$app->getProperty('pagination');


        if ($this->isAjax()) {
            debug($_GET);
            die;
        }


        $total = \R::count('product', "category_id IN ($ids)");
        $pagination = new Pagination($page, $perpage, $total);
        // С какой записи начинать выбирать
        $start = $pagination->getStart();

        // var_dump($pagination);
        // echo $pagination;


        // получаем продукты
        $products = \R::find('product', "category_id IN ($ids) LIMIT $start, $perpage");
        // debug($products);

        // передадим теперь все данные в ВИД
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'total')); // данные для представления
    }
}
