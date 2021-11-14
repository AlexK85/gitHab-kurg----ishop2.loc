<?php

namespace ishop;

use wfm\traits\TSingleton;

class Registry
{
    use TSingletone; // по факту скопировали код трейта  

    // Сюда будем складывать все свойства
    public static $properties = [];

    public function setProperty($name, $value)
    {
        self::$properties[$name] = $value;
    }

    public function getProperty($name)
    {
        if (isset(self::$properties[$name])) {
            return self::$properties[$name];
        }
        return null;
    }

    // Метод для ДЕБАГА
    public function getProperties()
    {
        return self::$properties;
    }
}
