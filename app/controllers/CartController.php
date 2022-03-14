<?php

namespace app\controllers;

use app\models\Cart;
use app\models\User;
use app\models\Order;

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
    public function showAction()
    {
        $this->loadView('cart_modal');
    }



    public function deleteAction()
    {
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

    public function clearAction()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);

        $this->loadView('cart_modal');
    }

    public function viewAction()
    {
        $this->setMeta('Корзина');
    }

    public function checkoutAction()
    {
        if (!empty($_POST)) {
            //регистрация пользователя
            if (!User::checkAuth()) {
                //если не пусто
                if (!empty($_POST)) {
                    $user = new User();
                    $data = $_POST;
                    $user->load($data);
                    // debug($user->attributes);

                    if (!$user->validate($data) || !$user->checkUnique()) {
                        // echo 'NO';
                        debug($user->errors);
                        $user->getErrors();
                        $_SESSION['form_data'] = $data;
                        redirect();
                    } else {
                        // echo 'OK';
                        // $_SESSION['success'] = 'OK';
                        // для скрытия хеша в поле password в БД
                        $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                        if (!$user_id = $user->save('user')) {
                            $_SESSION['error'] = 'Ошибка!';
                            redirect();
                        }
                        // $_SESSION['success'] = 'Пользователь зарегестрирован';
                        // redirect();
                    }
                    // die;
                    // redirect();
                }

                //сохранение заказа
                $data['user_id'] = isset($user_id) ? $user_id : $_SESSION['user']['id'];
                $data['note'] = !empty($_POST['note']) ? $_POST['note'] : '';
                $user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : $_POST['email'];
                //получаем номер заказа
                //создаёт новый заказа в таблицке order и вернёт нам номер заказа
                $order_id = Order::saveOrder($data);
                Order::mailOrder($order_id, $user_email);
            }
            redirect();
        }
    }
}
