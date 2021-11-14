<?php

namespace ishop\base;

use ishop\Db;

// Этот класс будет отвечать за работу с данными (БД, волидация, функции, которые будут обрабатывать данные)
abstract class Model
{
    // Тут будет храниться массив свойств модели, которая будет идентичен полям таблицы БД 
    public $attributes = []; 
    // Для складывания ошибок
    public $errors = [];
    //Для правил волидации данных
    public $rules = [];

    public function __construct()
    {
        Db::instance();
    }
}
