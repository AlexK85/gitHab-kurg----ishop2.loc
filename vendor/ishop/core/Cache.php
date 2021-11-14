<?php

namespace ishop;

class Cache
{
    // Реализовывать будет патерн TSingletone
    // Т.е. мы будем создавать объект класса Cache только один раз
    use TSingletone;

    // создадим СЕТТЕР, с помощью которого мы что-то запишем в КЭШ
    public function set($key, $data, $seconds = 3600) // 3600 это 1 час
    {
        // Если $seconds вернёт иснину (больше нуля)
        if ($seconds) {
            // Для чего нам нужен массив? Что бы сформировать конечное время, на которое мы КЭШируем данные
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            // file_put_contents() - записать данные в КЭШ и CACHE ведёт в папку tmp/cache, а потом md5 зашифрует(хеширует), что бы пользователь не положил в ключ какой то запрещённый для файловой системы символ. потом .txt это расширение. А serialize сериализует весь контент в строку.
            if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
                return true; 
            }
        }
        return false;
    }



    // Теперь ГЕТТЕР, с помощью которого мы что-то получим из КЭШа
    public function get($key)
    {
        // Нам необходимо получить путь к файлу
        $file = CACHE . '/' . md5($key) . '.txt';
        // Если существует такой файл $file
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));
            // Проверяем, не устарели ли кешированные данные
            // Берём текущую метку времени time() и если она меньше или равна $content['end_time']
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($file); // Данные устарели и удалим $file
        }
        // Это если $file не существует
        return false; // Если не вернули $content возвращаем false
    }
    



    // Этот метод поможет нам удалить КЭШ
    public function delete($key)
    {
        // Нам необходимо получить путь к файлу
        $file = CACHE . '/' . md5($key) . '.txt';
        // И проверить: если таковой фаул существует тогда мы его просто удалим
        if (file_exists($file)) {
            unlink($file); // Данные устарели и удалим $file
        }
    }
}
