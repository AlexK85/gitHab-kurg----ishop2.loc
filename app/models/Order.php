<?php

namespace app\models;

//Модель для работы с заказом. 
class Order extends AppModel
{

    public static function saveOrder($data)
    {
        $order = \R::dispense('order'); // мы выгружаем данные в таблицу order
        $order->user_id = $data['user_id']; //заполняем данными и берём данные из $data['user_id']
        $order->note = $data['note']; //заполняем данными и берём данные из $data['usnote']
        $order->currency = $_SESSION['cart.currency']['code']; //необходима вылюта заказа, который совершил пользователь
        $order_id = \R::store($order); // возвращает id сохранённой записи
        self::saveOrderProduct($order_id);

        return $order_id;
    }

    // для сохранения товаров из корзины
    public static function saveOrderProduct($order_id)
    {
        $sql_part = '';
        foreach ($_SESSION['cart'] as $product_id => $product) {
            $product_id = (int)$product_id;
            // номер заказа, id продукта, количество продукта, название продукта, цена продукта
            $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product['price']}),";
        }
        $sql_part = rtrim($sql_part, ',');
        // echo $sql_part;
        // die;

        // формируем запрос
        // $query = " INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part";
        // var_dump($query);
        // die;

        \R::exec("INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES " . $sql_part);
    }

    // для отправки письма на email
    public static function mailOrder($order_id, $user_mail)
    {
    }
}
