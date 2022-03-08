<?php

namespace ishop\base;

use ishop\Db;
use Valitron\Validator;

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


    //метод будет загружать данные из формы в модель
    public function load($data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }


    public function validate($data)
    {
        $v = new Validator();
        $v->rules($this->rules);
        if ($v->validate()) {
            return true;
        }

        $this->errors = $v->errors();
        return false;
    }
}
