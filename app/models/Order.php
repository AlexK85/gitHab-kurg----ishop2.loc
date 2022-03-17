<?php

namespace app\models;

use ishop\App;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;


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
        // Create the Transport
        $transport = (new Swift_SmtpTransport(App::$app->getProperty('smtp_host'), App::$app->getProperty('smtp_port'), App::$app->getProperty('smtp_protocol')))
            ->setUsername(App::$app->getProperty('smtp_login'))
            ->setPassword(App::$app->getProperty('smtp_password'));


        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);


        // Create a message
        ob_start(); // подключение буферизации
        require APP . '/views/mail/mail_order.php';

        // И в переменную $body вернём из буфера данные 
        $body = ob_get_clean();


        $message_client = (new Swift_Message("Заказ №{$order_id}"))
            ->setFrom([App::$app->getProperty('smtp_login') => 'shop_name'])
            ->setTo(App::$app->getProperty('user_email'))
            ->setBody($body, 'text/html');


        // письмо для администратора
        $message_admin = (new Swift_Message("Заказ №{$order_id}"))
            ->setFrom([App::$app->getProperty('smtp_login') => 'shop_name'])
            ->setTo(App::$app->getProperty('admin_email'))
            ->setBody($body, 'text/html');


        // Send the message
        $result = $mailer->send($message_client);
        // Send the message
        $result = $mailer->send($message_admin);

        // очищаем корзину 
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.currency']);

        // сообщение об успехе
        $_SESSION['success'] = 'Спасибо за Ваш заказ. В ближайшее время с Вами свяжется менеджер для согласования заказа!';
    }
}
