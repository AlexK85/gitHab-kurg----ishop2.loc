<?php

namespace app\models;

use ishop\App;

// для получения дочерних категорий
class Category extends AppModel
{

    public function getIds($id)
    {
        $cats = App::$app->getProperty('cats');
        // debug($cats);
        $ids = null;
        foreach ($cats as $k => $v) {
            if ($v['parent_id'] == $id) {
                $ids .= $k . ',';
                // в переменную $ids рекурсивно вызовем $this->getIds
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }
}
