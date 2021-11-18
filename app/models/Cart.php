<?php

namespace app\models;

use ishop\App;


/* Array
(
    [1] => Array
        (
           [qty] => QYU
           [name] => NAME
           [price] => PRICE
           [img] => IMG
        )
   [10] => Array
        (
           [qty] => QYU
           [name] => NAME
           [price] => PRICE
           [img] => IMG
        )
    )
    [qty] => QTY,
    [sum] => SUM
 */


class Cart extends AppModel
{

    // Принимает $product который нужно добавить в корзину
    // $qty количество
    // $mod вариант товара
    public function addToCart($product, $qty = 1, $mod = null)
    {
        //  echo 'Cart ';

        // Если у нас не существует в сессии такого элемента'cart.currency'
        if (!isset($_SESSION['cart.currency'])) {
            // создадим $_SESSION['cart.currency'] и положим в него активную валюту 'currency'
            $_SESSION['cart.currency'] = App::$app->getProperty('currency');
        }

        // debug($mod);

        if ($mod) {
            // создадим $ID и положим в неё id товара
            $ID = "{$product->id}-{$mod->id}";
            // нужно паказать наименование товара, а в скобках его цвет
            $title = "{$product->title} ({$mod->title})";
            // нужен так же прайс, берём его из $mod->price
            $price = $mod->price;
        } else {
            // в противном случае заполняем всё это дело БАЗОВЫМИ ВЕЩАМИ
            $ID = $product->id;
            $title = $product->title;
            $price = $product->price;
        }
        // debug($_SESSION);
        // debug($ID);
        // debug($title);
        // debug($price);  


        // Если существует в $_SESSION['cart'] такой [$ID]
        if ($_SESSION['cart'][$ID]) {
            // мы возьмём $_SESSION['cart'][$ID] возьмём его ЗНАЧЕНИЕ и ПРИБАВИМ к $qty
            $_SESSION['cart'][$ID]['qty'] += $qty;
        } else {
            // тогда создадим такой элемент и этот массив заполним необходимыми данными
            $_SESSION['cart'][$ID] = [
                'qty' => $qty,
                'title' => $title,
                'alias' => $product->alias,
                // $_SESSION['cart.currency'] уже привязан к ВАЛЮТЕ  по этому его и умножаем к $price и ['value'] эту КУРС
                'price' => $price * $_SESSION['cart.currency']['value'],
                'img' => $product->img
            ];
        }
        // реализация последней части массива [qty] => QTY, [sum] => SUM
        // всё это происходит при добавлении товара в корзину

        // Если у нас существует $_SESSION['cart.qty'] в этом случае мы его возьмём и ПРИБАВИМ к нему переданное $qty (количество, которое мы кладём в карзину дополнительно) 
        // иначе запишем туде добавляемое количество
        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;

        // Если у нас существует $_SESSION['cart.sum'] в этом случае мы его возьмём и ПРИБАВИМ к нему $qty (количество, которое добавляется в карзину ) УМНОЖЕННОЕ на (КУРС АКТИВНОЙ ВАЛЮТЫ - $_SESSION['cart.currency']['value'] умноженную на $price)
        // иначе если НЕТ ТОВАРА, мы должны взять количество $qty и умножить (на активную валюту $_SESSION['cart.currency']['value'] умноженную на $price)
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * ($price * $_SESSION['cart.currency']['value']) : $qty * ($price * $_SESSION['cart.currency']['value']);
    }

    public function deleteItem($id)
    {
        $qtyMinus = $_SESSION['cart'][$id]['qty'];
        $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price']; // в итоге мы получим на какую сумму имено данные позиции лежат в корзине
        $_SESSION['cart.qty'] -= $qtyMinus;
        $_SESSION['cart.sum'] -= $sumMinus;
        unset($_SESSION['cart'][$id]);
    }


    // Пересчёт корзины если пользователь поменял валюту
    // на вход принимает массив новой валюты
    public static function recalc($curr)
    {
        // debug($curr);
        // debug($_SESSION);
        // die;
        // если валюта в сессии есть в которй мы клали товар
        if (isset($_SESSION['cart.currency'])) {
            // если товар положен в базоваой валюте
            if ($_SESSION['cart.currency']['base']) {
                // тогда получим перевод из базовой валюты в не базовую
                $_SESSION['cart.sum'] *= $curr->value;
            } else {
                $_SESSION['cart.sum'] = $_SESSION['cart.sum'] / $_SESSION['cart.currency']['value'] * $curr->value;
            }

            // так же нужно поменять цену каждого товара 
            foreach ($_SESSION['cart'] as $k => $v) {
                // если товар уже в базовой валюте лежит 
                if ($_SESSION['cart.currency']['base']) {
                    // тогда мы берём $_SESSION['cart'] обращаемся к текущему ключу [$k] и к цене данного товара 
                    $_SESSION['cart'][$k]['price'] *= $curr->value;
                } else {
                    $_SESSION['cart'][$k]['price'] = $_SESSION['cart'][$k]['price'] / $_SESSION['cart.currency']['value'] * $curr->value;
                }
            }
            // теперь нам нужно перезаписать товар в сессию
            foreach ($curr as $k => $v) {
                $_SESSION['cart.currency'][$k] = $v;
            }  
        }
    }
}
