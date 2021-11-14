<?php

namespace app\controllers;

use app\models\AppModel;
use app\widgets\currency\Currency;
use ishop\base\Controller;
use ishop\App;
use ishop\Cache;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route); // вызов родительского конструктора, что бы его не затереть
        new AppModel();  // создаём объект класса AppModel

        // запись в КУКИ
        // setcookie('currency', 'EUR', time() + 3600*24*7, '/'); 

        // $curr = Currency::getCurrencies(); // выведет ассоциативный массив  
        // debug($curr); 

        // запишим в реестр теперь. Это список всех доступных валют в свойстве currencies
        App::$app->setProperty('currencies', Currency::getCurrencies());
        // debug(App::$app->getProperties());

        App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));
        App::$app->getProperty('currency');
        // debug(App::$app->getProperties());  // появиться ещё один массив активной валютой currency

        // кладём в контейнер 
        App::$app->setProperty('cats', self::cacheCategory());
        // debug(App::$app->getProperties()); // распечатаем ВЕСЬ контейнер
    }

    public static function cacheCategory()
    {
        $cache = Cache::instance();
        // если мы получили данные из КЭША мы их вернём. 
        $cats = $cache->get('cats'); // тут получаем ключ $cats
        // если не получили данные из КЭША, тогда мы их получим из БД, запишим в КЭШ и соответственно вернём
        if (!$cats) {
            $cats = \R::getAssoc("SELECT * FROM category");
            $cache->set('cats', $cats);
        }
        return $cats;
    }
}
