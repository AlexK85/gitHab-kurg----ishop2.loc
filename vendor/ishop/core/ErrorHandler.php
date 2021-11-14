<?php

namespace ishop;

use cls;

class ErrorHandler
{
    // Конструктор потребуется для того, что бы узнать состояние константы ДЕБАГ
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1); // error_reporting показывает все ошибки 
        } else {
            error_reporting(0);  // выключает показ ошибок
        }
        // Далее все ошибки обрабатываем  речь идёт об исключениях
        set_exception_handler([$this, 'exceptionHendler']); // функция позволит нам назначить для обработки исключений свою функцию 
    }

    // объявим метод, который будет перехватывать/обрабатывать исключения 
    public function exceptionHendler($e)
    {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }


    protected function logErrors($message = '', $file = '', $line = '')
    {
        // Далее нам потребуется метод для логирования ошибог, ошибку нужно отправить в какой либо файл 
        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$message} | Файл: {$file} | Строка: {$line}\n================\n", 3, ROOT . '/tmp/errors.log'); // Должен создаться файл /tmp/errors.log
    }

    // Метод для вывода ошибок
    protected function displayError($errno, $errstr, $errfile, $errline, $responce = 404)
    {
        // Первое что мы должны сделать перед тем как показать ошибку это показать заголовок 
        // для этого используем функцию http_response_code 
        http_response_code($responce);
        // Далее мы должны подключать некий шаблон по условию 
        if ($responce == 404 && !DEBUG) {
            require WWW . '/errors/404.php';
            die;
        }

        if (DEBUG) {
            require WWW . '/errors/dev.php';
        } else {
            require WWW . '/errors/prod.php';
        }
        die;
    }
}
