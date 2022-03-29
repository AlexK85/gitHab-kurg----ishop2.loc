<?php

namespace app\controllers;

use app\models\Breadcrumbs;
use app\models\Category;
use app\widgets\filter\Filter;
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


        $sql_part = '';

        if (!empty($_GET['filter'])) {
            // $filter = $_GET['filter'];

            // формирование SQL запроса 
            /* 
            SELECT product .* FROM product WHERE category_id IN (6) AND id IN
            (
                SELECT product_id FROM attribute_product WHERE attr_id IN (1,5) GROUP BY product_id HAVING COUNT(product_id) = 2
            )
            */
            $filter = Filter::getFilter();
            // debug($filter);
            // die;
            if ($filter) {
                $cnt = Filter::getCountGroups($filter);
                $sql_part = "AND id IN (SELECT product_id FROM attribute_product WHERE attr_id IN ($filter) GROUP BY product_id HAVING COUNT(product_id) = $cnt)";
            }

            // debug($filter);
            // die;
        }


        // if ($this->isAjax()) {  
        // debug($filter);
        //     die;
        // }


        $total = \R::count('product', "category_id IN ($ids) $sql_part");
        // debug($total);
        // die;

        $pagination = new Pagination($page, $perpage, $total);
        // С какой записи начинать выбирать
        $start = $pagination->getStart();

        // var_dump($pagination); 
        // echo $pagination;


        // получаем продукты
        $products = \R::find('product', "category_id IN ($ids) $sql_part LIMIT $start, $perpage");
        // debug($products);
        // die;


        if ($this->isAjax()) {
            // передаём наименование вида и передаём некие переменные в данный вид  
            $this->loadView('filter', compact('products', 'total', 'pagination'));
        }


        // передадим теперь все данные в ВИД
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'total')); // данные для представления
    }
}
