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

    public static function saveOrderProduct($order_id)
    {
    }

    public static function mailOrder($order_id, $user_mail)
    {
    }
}
