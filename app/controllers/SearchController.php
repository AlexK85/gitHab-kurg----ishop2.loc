<?php

namespace app\controllers;

class SearchController extends AppController
{

    public function typeaheadAction()
    {
        if ($this->isAjax()) {
            // Если не пуст запрос, тогда мы возьмём его (запрос) и в противном случае в $query  будет положен null
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;

            if ($query) {
                $products = \R::getAll('SELECT id, title FROM product WHERE title LIKE ? LIMIT 9', ["%{$query}%"]);
                echo json_encode($products);
            }
        }
        die;
    }
}
