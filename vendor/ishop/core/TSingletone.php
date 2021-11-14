<?php

namespace ishop;

trait TSingletone
{
    private static $instance;
    public static function instance()
    {
        if (self::$instance === null) {   // Если у нас свойство пусто 
            self::$instance = new self;   // Тогда в него положим объект данного класса 
        }
        return self::$instance;           // И вернём его. А если не пусто, тогда просто вернём объект
    }
}
 