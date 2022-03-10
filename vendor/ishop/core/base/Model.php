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


    public function save($table)
    {
        $tbl = \R::dispense($table);
        foreach ($this->attributes as $name => $value) {
            $tbl->$name = $value;
        }
        return \R::store($tbl);
    }


    public function validate($data)
    {
        Validator::langDir(WWW . '/validator/lang');
        Validator::lang('ru');
        $v = new Validator($data);
        $v->rules($this->rules);
        if ($v->validate()) {
            return true;
        }

        $this->errors = $v->errors();
        return false;
    }


    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $item) {
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        //для запоминания ошибок
        $_SESSION['error'] = $errors;
    }
}
