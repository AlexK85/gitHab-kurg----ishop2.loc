<?php

namespace app\controllers;

use app\models\Cart;


class CartController extends AppController
{

    public function addAction()
    {
        // debug($_GET);

        // Получим данные из массива $_GET

        // 
        $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
        $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
        $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;

        // для того, что бы получать модификаторы в данную переменную
        $mod = null;   // $mod инициализирована

        // Получаем данные продукта
        if ($id) {
            $product = \R::findOne('product', 'id = ?', [$id]);
            if (!$product) {
                return false;
            }
            // debug($product);

            // Получаем данные модификатора
            if ($mod_id) {
                $mod = \R::findOne('modification', 'id = ? AND product_id = ?', [$mod_id, $id]);
            }
            // debug($mod);
        }
        // die;
        // Создадим объект корзины
        $cart = new Cart();
        $cart->addToCart($product, $qty, $mod);

        // Если у нас запрос пришёл АЯКСОМ 
        if ($this->isAjax()) {
            // в этом случае мы должны загрузить ответом 
            $this->loadView('cart_modal');
        }
        // die;
        // если данные пришли не АЯКСом 
        redirect();
    }

   


    // Этот ЭКШН просто подключает 'cart_modal' тут идёт распечатка корзины 
    public function showAction() {
        $this->loadView('cart_modal');
    }



    public function deleteAction() {
        // если не пусто $_GET['id']  
        $id = !empty($_GET['id']) ? $_GET['id'] : null;
        // если СУЩЕСТВУЕТ в $_SESSION['cart'] такой $id
        if (isset($_SESSION['cart'][$id])) {
            // тогда создадим объект карзины 
            $cart = new Cart();
            $cart->deleteItem($id);
        }

          
        if ($this->isAjax()) {
            // в этом случае мы должны загрузить ответом 
            $this->loadView('cart_modal');
        }
        // если данные пришли не АЯКСом 
        redirect();
    }
}
